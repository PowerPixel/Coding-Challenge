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
        $user = $this->getUser();
        $languagesRepo = $this->getDoctrine()->getRepository(Language::class);
        $languages = $languagesRepo->findAll();
        $solvingRepo = $this->getDoctrine()->getRepository(Solving::class);
        $lastSubmittedCode = "";
        if(isset($user)){
            $solvingEntry = $solvingRepo->findOneBy([
                "user_id" => $user->getId(),
                "exercise_id" => $id
            ]);
        }
        if(isset($solvingEntry)) {
            $lastSubmittedCode = $solvingEntry->getLastSubmittedCode();
        }
        return $this->render('exercise_solving/index.html.twig', [
            'exercise' => $exercise,
            'description' => $description,
            'lastSubmittedCode' => $lastSubmittedCode,
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
            $solvingRepo = $this->getDoctrine()->getRepository(Solving::class);
            $solvingEntry = $solvingRepo->findOneBy([
                "user_id" => $programData["userId"],
                "exercise_id" => $programData["exerciseId"]
            ]);
            $userRepo = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepo->find($programData["userId"]);

            $ponderateScore = $userScore * $exercise->getDifficulty();

            if(isset($solvingEntry)) {
                $newSolving = $solvingEntry->setLastSubmittedCode($programData["submittedCode"]["source"]);
                if($userScore > $solvingEntry->getCompletedTestAmount()) {
                    $user->setTotalScore($user->getTotalScore() + ($ponderateScore - $solvingEntry->getCompletedTestAmount() * $exercise->getDifficulty())); 
                    $newSolving = $solvingEntry->setCompletedTestAmount($userScore);
                }
            } else {
                $newSolving = new Solving();
                $newSolving->setUserId($user);
                $newSolving->setExerciseId($exercise);
                $newSolving->setCompletedTestAmount($userScore);
                $newSolving->setLastSubmittedCode($programData["submittedCode"]["source"]);
                $user->setTotalScore($user->getTotalScore() + $ponderateScore);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newSolving);
            $entityManager->flush();
            
            return new Response(json_encode($outputTests));
        }
        return new JsonResponse("Not Authorized");
    }
}
