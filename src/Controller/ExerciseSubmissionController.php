<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\ExerciseState;
use App\Entity\Language;
use App\Entity\Restricted;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use ZipArchive;

/**
 * @Route("/submit")
 * @IsGranted("ROLE_USER")
 */
class ExerciseSubmissionController extends AbstractController
{
    /**
     * @Route("/", name="submit_exercise")
     */
    public function index(Request $req): Response
    {
        $builder = $this->createFormBuilder();
        $form = $builder->add("fichier",FileType::class, [
            "attr" => ["accept" => "application/zip"],
            "label" => "Fichier à uploader"
        ])
                        ->add("Soumettre", SubmitType::class)
                        ->getForm();
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $user = $this->getUser();
            $newFilename = $user->getId() . "-" . date('d-m-Y') . '-' . date('H:i') . "-" . uniqid() . ".zip";
            $file = $form->getData()["fichier"];
            $exerciseName = str_replace(' ','',pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $file->move('/tmp',$newFilename);
            $archivePath = '/tmp/'.$newFilename;
            $isArchiveValid = $this->verifyExerciseArchive($archivePath);
            if(!$isArchiveValid){
                unlink($archivePath);
                return $this->render('exercise_submission/index.html.twig',[
                    'form' => $form->createView(),
                    'error' => 'Le format de l\'archive est incorrect.'
                ]);
            }
            $tempFolderPath = explode('.',$archivePath)[0];
            if(is_dir(Exercise::$PATH_TO_EXERCISES_FOLDER . '/' . $exerciseName)){ // Vérifie si le dossier avec un même nom existe déjà
                return $this->render('exercise_submission/index.html.twig',[
                    'form' => $form->createView(),
                    'error' => 'Il y\'a déjà un exercice avec ce nom'
                ]);
            }
            unlink($archivePath);
            
            $entityManager = $this->getDoctrine()->getManager();
            $exerciseAndRestrictions = $this->parseExercise($tempFolderPath,$exerciseName);
            $entityManager->persist($exerciseAndRestrictions[0]);
            $entityManager->flush();
            $exerciseAndRestrictions[1]->setExerciseId($exerciseAndRestrictions[0]);
            $entityManager->persist($exerciseAndRestrictions[1]);
            $entityManager->flush();
            // Suppression du dossier temporaire, boucle for each sur chaque fichier, car rmdir ne prends en charge que les dossiers vides.
            $files = array_diff(scandir($tempFolderPath),Array('.','..'));
            foreach($files as $file){
                unlink($tempFolderPath . '/' . $file);
            }
            rmdir($tempFolderPath);
            return $this->render('exercise_submission/index.html.twig',[
                'form' => $form->createView(),
                'success' => "Exercice soumis avec succés ! Veuillez attendre la validation d'un administrateur."
            ]);
        }
        return $this->render('exercise_submission/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
    /**
     * This function checks if the archive's is well formed.
     *
     * @param String $pathToArchive The path to the archive to check integrity of.
     * @return boolean true if the archive is a proper, false otherwise
     */
    public function verifyExerciseArchive(String $pathToArchive): bool
    {
        $zip = new ZipArchive;
        $filesNamesRegex = ["/description.txt/", "/inputDescription.txt/", "/outputDescription.txt/",
        "/input[0-9]*.txt/","/output[0-9]*.txt/", "/settings.json/"];
        if($zip->open($pathToArchive)){
            for($i = 0; $i < $zip->numFiles; $i++)
            {  
                $stat = $zip->statIndex($i);
                if($stat["size"] != 0){ // Permet de s'assurer que le fichier n'est pas un dossier.
                    $numberOfMatches = 0;
                    $filename = $zip->getNameIndex($i);
                    foreach($filesNamesRegex as $regex){
                        $numberOfMatches += preg_match($regex,$filename);
                    }
                    if($numberOfMatches == 0){
                            return false; // Si le nom de fichier ne corresponds à aucune REGEX, alors ce fichier ne devrait pas être dans l'archive, 
                                          // et la validité de l'archive est compromise
                    }
                }
                else{
                    return false; // Si c'est un dossier, rejeter l'archive. (La spécification du format d'archive ne prends
                                  // aucun dossier.
                }
                
            } 
        }
        $pathToFolder = explode('.',$pathToArchive)[0];
        return $this->checkSettings($pathToArchive,$pathToFolder);
    }

    /**
     * This function checks the integrity of the settings file inside of the archive.
     *
     * @param String $pathToArchive The path to the archive to check integrity of.
     * @return boolean true if the settings are proper, false otherwise
     */
    public function checkSettings(String $pathToArchive, String $pathToFolder): bool
    {
        $zip = new ZipArchive;
        if($zip->open($pathToArchive)){
            $zip->extractTo($pathToFolder);
            $rawJsonText = file_get_contents($pathToFolder . "/settings.json");
            $settingsArray = json_decode($rawJsonText,true);
            $isDifficultyValid = (gettype($settingsArray['difficulty']) === "integer") && ($settingsArray['difficulty'] >= 0) && 
            ($settingsArray['difficulty'] <= 10);
            $isLanguageValid = gettype($settingsArray['language']) === "array";
            
            $isTimeoutValid = (gettype($settingsArray['timeout']) === "integer") && ($settingsArray['timeout']>=0);
            return $isDifficultyValid && $isLanguageValid && $isTimeoutValid;
        }
        return true;
    }
    /**
     * This method parse the archive and transforms it into an array containing an exercise and a restricted object.
     * It also moves the directory from the temporary folder of the machine to the exercises folder.
     *
     * @param String $pathToFolder The path to the exercise temp folder to parse.
     * @param String $exerciseName The name of the exercise. Used for the exercise folder.
     * @return Array The generated array of exercise and constraint.
     */
    public function parseExercise(String $pathToTempFolder, String $exerciseName): Array
    {
        $exercise = new Exercise();
        $languageRestrictions = new Restricted();
        $usersRepo = $this->getDoctrine()->getRepository(User::class);
        $exerciseStateRepo = $this->getDoctrine()->getRepository(ExerciseState::class);
        $languageRepo = $this->getDoctrine()->getRepository(Language::class);
        $creator = $usersRepo->find($this->getUser()->getId());
        
        $exerciseState = $exerciseStateRepo->find(1);
        $settingsContent = file_get_contents($pathToTempFolder . '/settings.json');
        $settingsArray = json_decode($settingsContent,true);
        $exercise->setCreator($creator);
        $exercise->setDescription(file_get_contents($pathToTempFolder . '/description.txt'));
        $exercise->setDifficulty($settingsArray["difficulty"]);
        $exercise->setFolderPath(Exercise::$PATH_TO_EXERCISES_FOLDER . "/" . $exerciseName);
        $exercise->setState($exerciseState);
        $exercise->setName($exerciseName);
        $exercise->setSubmitDate(new \DateTime());

        // Déplacement du dossier temporaire
        mkdir(Exercise::$PATH_TO_EXERCISES_FOLDER . '/' . $exerciseName);
        $fichiers = array_diff(scandir($pathToTempFolder), Array('.','..'));
        foreach($fichiers as $fichier){
            rename($pathToTempFolder . '/' . $fichier, 
                    Exercise::$PATH_TO_EXERCISES_FOLDER . '/' . $exerciseName . '/' . $fichier);
        }
        
        
        foreach($settingsArray["language"] as $languageConstraint){
            $language = $languageRepo->findOneBy([
                'name' => $languageConstraint,
            ]);
            $languageRestrictions->addLanguage($language);
        }
        return Array($exercise,$languageRestrictions);
    }
}