<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BonjourController extends AbstractController
{
    /**
     * @Route("/bonjour", name="bonjour")
     */
    public function index()
    {
        return $this->render('bonjour/index.html.twig', [
            'aQui' => "joyeux contribuable",
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
