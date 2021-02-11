<?php

namespace App\Controller;

use App\Entity\Challenge;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChallengeController extends AbstractController
{
    /**
     * @Route("/challenge/{id}", name="challenge")
     */
    public function index(int $id): Response
    {
        $challenge = $this->getDoctrine()->getRepository(Challenge::class)->find($id);
        return $this->render('challenge/index.html.twig', [
            "challenge" => $challenge
        ]);
    }
}
