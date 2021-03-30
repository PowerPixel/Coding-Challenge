<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Exercise;
use App\Entity\Challenge;
use App\Repository\ExerciseRepository;
use App\Repository\ChallengeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $repoExo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercises = $repoExo->findAll();
        $exercisesAttente = $repoExo->findBy([
            'state' => 1,
        ]);
        $countUsersAttente = count($this->getDoctrine()->getRepository(User::class)->findByRoles("[\"ROLE_NEW_USER\"]"));
        $countExerciceAttente = count($exercisesAttente);
        return $this->render('index/index.html.twig', [
            'exercises' => $exercises,
            'countUsersAttente' => $countUsersAttente,
            'countExerciceAttente' => $countExerciceAttente
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
