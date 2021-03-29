<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\Solving;
use App\Entity\User;
use App\Entity\Language;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Json;

/**
 * @Route("/exercise/{id}")
 */
class ExerciseSolvingController extends AbstractController
{
    /**
     * @Route("/solve", name="exercise_solving")
     * @IsGranted("ROLE_USER")
     */
    public function index(int $id): Response
    {
        $exercisesRepo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercise = $exercisesRepo->find($id);
        $exerciseFolderPath = $exercise->getFolderPath();
        $description = file_get_contents($exerciseFolderPath . "/description.txt");
        $languagesRepo = $this->getDoctrine()->getRepository(Language::class);
        $languages = $languagesRepo->findAll();
        return $this->render('exercise_solving/index.html.twig', [
            'exercise' => $exercise,
            'description' => $description,
            'languages' => $languages
        ]);
    }
    /**
     * @Route("/run", name="run")
     */
    public function run(Request $request,HttpClientInterface $client){
        if($request->isXmlHttpRequest()){
            $programData = json_decode($request->getContent(), true);

            $exercisesRepo = $this->getDoctrine()->getRepository(Exercise::class);
            $exercise = $exercisesRepo->find($programData["exerciseId"]);
            $pathToExercise = $exercise->getFolderPath();
            $inputFiles = glob($pathToExercise . '/input[0-9]*.txt');
            $inputTests = array();
            for($i = 0; $i < count($inputFiles); $i++) {
                $content = file_get_contents($inputFiles[$i]);
                $inputTests[] = [
                    "stdin" => $content
                ];
            }
            
            $datas = [
                "lang" => $programData["submittedCode"]["lang"],
                "source" => $programData["submittedCode"]["source"],
                "tests" => $inputTests
            ];

            $response = $client->request(
                'POST',
                'http://localhost:42920/run',
                [
                    'body' => json_encode($datas)
                ]
            );
            $response->getInfo('debug');
            $returnedData = json_decode($response->getContent(), true);

            // Checking the output validity
            $outputFiles = glob($pathToExercise . '/output[0-9]*.txt');
            $outputTests = array();
            $userScore = 0;

            if(isset($returnedData['tests'])) {
                for($i = 0; $i < count($outputFiles); $i++) {
                    $content = file_get_contents($outputFiles[$i]);
                    if(rtrim($content) == rtrim($returnedData['tests'][$i]['stdout'])) {
                        $userScore ++;
                        $outputTests[] = [
                            "name" => "Test " . ($i+1),
                            "check" => TRUE,
                            "stdout" => "✓ Test passé !",
                            "stderr" => $returnedData['tests'][$i]['stderr']
                        ];
                    } else {
                        $outputTests[] = [
                            "name" => "Test " . ($i+1),
                            "check" => FALSE,
                            "stdout" => "✗ Test échoué : Sortie incorrecte",
                            "stderr" => $returnedData['tests'][$i]['stderr']
                        ];
                    }
                }
            } else {
                $outputTests[] = [
                    "check" => FALSE,
                    "stdout" => "✗ Tests échoués : Erreur de compilation",
                    "stderr" => $returnedData['compile']['stderr']
                ];
            }

            // Saving user solution on database
            $languagesRepo = $this->getDoctrine()->getRepository(Language::class);
            $language = $languagesRepo->findOneBy(["name" => $programData["submittedCode"]["lang"]]);
            $solvingRepo = $this->getDoctrine()->getRepository(Solving::class);
            $solvingEntry = $solvingRepo->findOneBy([
                "user_id" => $programData["userId"],
                "exercise_id" => $programData["exerciseId"],
                "language_id" => $language->getId()
            ]);

            $userRepo = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepo->find($programData["userId"]);

            if(isset($solvingEntry)) {
                $newSolving = $solvingEntry->setLastSubmittedCode($programData["submittedCode"]["source"]);
            } else {
                $newSolving = new Solving();
                $newSolving->setUserId($user);
                $newSolving->setExerciseId($exercise);
                $newSolving->setLanguageId($language);
                $newSolving->setLastSubmittedCode($programData["submittedCode"]["source"]);
            }

            // Saving new score in total user's score
            $ponderateScore = $userScore * $exercise->getDifficulty();

            $bestSolve = $solvingRepo->findBestCompleteTestAmountBy($user->getId(), $exercise->getId());
            if($bestSolve) {
                if($userScore > $bestSolve->getCompletedTestAmount()) {
                    $user->setTotalScore($user->getTotalScore() + ($ponderateScore - $solvingEntry->getCompletedTestAmount() * $exercise->getDifficulty())); 
                }
            } else {
                $user->setTotalScore($user->getTotalScore() + $ponderateScore);
            }

            $newSolving = $newSolving->setCompletedTestAmount($userScore);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newSolving);
            $entityManager->persist($user);
            $entityManager->flush();
            
            return new Response(json_encode($outputTests));
        }
        return new JsonResponse("Not Authorized");
    }

    /**
     * @Route("/lang", name="lang")
     */
    public function changeLanguage(Request $request,HttpClientInterface $client){
        if($request->isXmlHttpRequest()){
            $data = json_decode($request->getContent(), true);

            $languagesRepo = $this->getDoctrine()->getRepository(Language::class);
            $language = $languagesRepo->findOneBy(['name' => $data["lang"]]);
            
            $solvingRepo = $this->getDoctrine()->getRepository(Solving::class);
            $solvingEntry = $solvingRepo->findOneBy([
                "user_id" => $data["userId"],
                "exercise_id" => $data["exerciseId"],
                "language_id" => $language->getId()
            ]);

            $code = "";
            if(isset($solvingEntry)) {
                $code = $solvingEntry->getLastSubmittedCode();
            } else {
                $code = $language->getCodeSnippet();
            }
            
            return new Response($code);
        }
        return new JsonResponse("Not Authorized");
    }
}
