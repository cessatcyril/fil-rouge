<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuDeTestController extends AbstractController
{
    /**
     * @Route("/jeu/de/test", name="jeu_de_test")
     */
    public function index(): Response
    {
        return $this->render('jeu_de_test/index.html.twig', [
            'controller_name' => 'JeuDeTestController',
        ]);
    }
}
