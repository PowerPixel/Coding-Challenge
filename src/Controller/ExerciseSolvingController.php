<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\Solving;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class ExerciseSolvingController extends AbstractController
{
    /**
     * @Route("/exercise/{id}/solve", name="exercise_solving")
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
        // $lastSubmittedCode = $solvingEntry->getLastSubmittedCode();
        return $this->render('exercise_solving/index.html.twig', [
            'exercise' => $exercise,
            'description' => $description,
            //'lastSubmittedCode' => $lastSubmittedCode
        ]);
    }
}
