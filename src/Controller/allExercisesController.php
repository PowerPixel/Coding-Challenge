<?php

namespace App\Controller;

use App\Entity\Exercise;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class allExercisesController extends AbstractController
{
    /**
     * @Route("allExercises", name="allExercises")
     */
    public function index(): Response
    {
        $repoExo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercises = $repoExo->findAll();
        return $this->render('allExercises/index.html.twig', [
            'exercises' => $exercises
        ]);
    }
}