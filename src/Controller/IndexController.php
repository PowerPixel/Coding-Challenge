<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\Exercise;
use App\Repository\ChallengeRepository;
use App\Repository\ExerciseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $repoChall = $this->getDoctrine()->getRepository(Challenge::class);
        $challenges = $repoChall->findAll();
        $repoExo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercises = $repoExo->findAll();
        return $this->render('index/index.html.twig', [
            'challenges' => $challenges, 
            'exercises' => $exercises
        ]);
    }

    /**
     * @Route("/icons", name="icones")
     */
    public function icons()
    {
        return $this->render('bonjour/icons.html.twig');
    }
}
