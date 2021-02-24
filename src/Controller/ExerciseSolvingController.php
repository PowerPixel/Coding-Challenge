<?php

namespace App\Controller;

use App\Entity\Exercise;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciseSolvingController extends AbstractController
{
    /**
     * @Route("/exercise/{id}/solve", name="exercise_solving")
     */
    public function index(int $id): Response
    {
        $exercisesRepo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercise = $exercisesRepo->find($id);
        $exerciseFolderPath = $exercise->getFolderPath();
        $description = file_get_contents($exerciseFolderPath . "/description.txt");
        return $this->render('exercise_solving/index.html.twig', [
            'exercise' => $exercise,
            'description' => $description
        ]);
    }
}
