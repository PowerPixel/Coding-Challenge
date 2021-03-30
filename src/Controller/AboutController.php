<?php

namespace App\Controller;

use App\Entity\About;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/About", name="About")
     */
    public function index(): Response
    {
        return $this->render('About/index.html.twig', []);
    }
}