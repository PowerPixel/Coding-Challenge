<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\Solving;
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
    public function index(int $id,LoggerInterface $logger): Response
    {
        $exercisesRepo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercise = $exercisesRepo->find($id);
        $exerciseFolderPath = $exercise->getFolderPath();
        $description = file_get_contents($exerciseFolderPath . "/description.txt");
        $user = $this->getUser();
        $solvingRepo = $this->getDoctrine()->getRepository(Solving::class);
        //$logger->info(var_dump($user));
        if(isset($user)){
            $solvingEntry = $solvingRepo->findOneBy([
                "user_id" => $user->getId()
            ]);
        }
        $lastSubmittedCode = $solvingEntry->getLastSubmittedCode();
        return $this->render('exercise_solving/index.html.twig', [
            'exercise' => $exercise,
            'description' => $description,
            'lastSubmittedCode' => $lastSubmittedCode
        ]);
    }
    /**
     * @Route("/run", name="run")
     */
    public function run(Request $request,HttpClientInterface $client){
        if($request->isXmlHttpRequest()){
            $programData = json_decode($request->getContent(), true);
            $response = $client->request(
                'POST',
                'http://localhost:42920/run',
                [
                    'body' => json_encode($programData["submittedCode"])
                ]
            );
            $response->getInfo('debug');
            $returnedData = $response->getContent();

            // Saving user solution on database
            $solvingRepo = $this->getDoctrine()->getRepository(Solving::class);
            $solvingEntry = $solvingRepo->findOneBy([
                "user_id" => $programData["userId"],
                "exercice_id" => $programData["exerciseId"]
            ]);
            if(isset($solvingEntry)) {
                $newSolving = $solvingEntry->setLastSubmittedCode($programData["submittedCode"]["source"]);
            } else {
                $newSolving = new Solving()
                    .setUserId($programData["userId"])
                    .setExerciseId($programData["exerciseId"])
                    .setCompletedTestAmount()
                    .setLastSubmittedCode($programData["sumbittedCode"]["source"]);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newSolving);
            $entityManager->flush();

            return new Response($returnedData);
        }
        return new JsonResponse("Not Authorized");
    }
}
