<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Repository\ChallengeRepository;
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
        return $this->render('index/index.html.twig', ['challenges' => $challenges]);
    }

    /**
     * @Route("/icons", name="icones")
     */
    public function icons()
    {
        return $this->render('bonjour/icons.html.twig');
    }
}
