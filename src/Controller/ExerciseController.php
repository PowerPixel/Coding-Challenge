<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\User;
use App\Entity\Solving;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciseController extends AbstractController
{
    /**
     * @Route("/exercise/{id}", name="exercise")
     */
    public function index(int $id): Response
    {
        $user_repo = $this->getDoctrine()->getRepository(User::class);
        $exercisesRepo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercise = $exercisesRepo->find($id);
        $solves = $this->getDoctrine()->getRepository(Solving::class)->findBy(["exercise_id" => $id]);
        $users = array();
        $pathToExercise = $exercise->getFolderPath();
        $inputFiles = glob($pathToExercise . '/input[0-9]*.txt');
        $testsCount = count($inputFiles);
        foreach ($solves as $solve) {
            $users[] = [
                "username" => $user_repo->findOneById($solve->getUserId())->getUsername(),
                "score" => $solve->getCompletedTestAmount()
            ];
        }
        return $this->render('exercise/index.html.twig', [
            "exercise" => $exercise,
            "user_scores" => $users,
            "testsCount" => $testsCount
        ]);
    }
}
