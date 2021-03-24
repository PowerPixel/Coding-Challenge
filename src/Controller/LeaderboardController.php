<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeaderboardController extends AbstractController
{
    /**
     * @Route("/leaderboard", name="leaderboard")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('classement/index.html.twig', [
         "users" => $users
        ]);
    }
}
