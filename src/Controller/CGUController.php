<?php

namespace App\Controller;

use App\Entity\CGU;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CGUController extends AbstractController
{
    /**
     * @Route("/CGU", name="CGU")
     */
    public function index(): Response
    {
        return $this->render('CGU/index.html.twig', []);
    }
}
