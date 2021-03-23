<?php

namespace App\Controller;


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
            $newFilename = $user->getId() . "-" . date('d.m.Y') . '-' . date('H:i') . "-" . uniqid() . ".zip";
            $file = $form->getData()["fichier"];
            $file->move('/tmp',$newFilename);
            $isArchiveValid = $this->verifyExerciseArchive('/tmp/'.$newFilename);
            if(!$isArchiveValid){
                return $this->render('exercise_submission/index.html.twig',[
                    'form' => $form->createView(),
                    'error' => 'Le format de l\'archive est incorrect.'
                ]);
            }
            parseArchive('/tmp/'.$newFilename);
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
        }
        return $this->checkSettings($pathToArchive);
    }

    /**
     * This function checks the integrity of the settings file inside of the archive.
     *
     * @param String $pathToArchive The path to the archive to check integrity of.
     * @return boolean true if the settings are proper, false otherwise
     */
    public function checkSettings(String $pathToArchive): bool
    {
        $zip = new ZipArchive;
        $tmpFolderPath = '/tmp/' . explode('.',$pathToArchive)[0];
        if($zip->open($pathToArchive)){
            $zip->extractTo($tmpFolderPath, array("settings.json"));
            $rawJsonText = file_get_contents($tmpFolderPath . "/settings.json");
            $settingsArray = json_decode($rawJsonText,true);
            $isDifficultyValid = (gettype($settingsArray['difficulty']) === "integer") && ($settingsArray['difficulty'] >= 0) && 
            ($settingsArray['difficulty'] <= 10);
            $isLanguageValid = gettype($settingsArray['language']) === "string";
            $isTimeoutValid = (gettype($settingsArray['timeout']) === "integer") && ($settingsArray['timeout']>=0);
            return $isDifficultyValid && $isLanguageValid && $isTimeoutValid;
        }
        else{
            return false;
        }
        return true;
    }
    /**
     * This method parse the archive and transforms it into an exercise object
     *
     * @param String $pathToArchive The path to the archive to check integrity of.
     * @return void
     */
    public function parseArchive(String $pathToFolder){

    }
}
