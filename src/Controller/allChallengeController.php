<?php

namespace App\Controller;

use App\Entity\Challenge;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class allChallengeController extends AbstractController
{
    /**
     * @Route("allChallenge", name="allChallenge")
     */
    public function index(): Response
    {
        $repoChall = $this->getDoctrine()->getRepository(Challenge::class);
        $challenges = $repoChall->findAll();
        return $this->render('allChallenge/index.html.twig', [
            'challenges' => $challenges
        ]);
    }
}
