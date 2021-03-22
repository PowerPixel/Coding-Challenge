<?php

namespace App\Controller;

use App\Entity\Exercise;
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
        $exercise = $this->getDoctrine()->getRepository(Exercise::class)->find($id);
        return $this->render('exercise/index.html.twig', [
            "exercise" => $exercise
        ]);
    }
}
