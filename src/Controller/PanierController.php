<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier/liste", name="panier_liste")
     */
    public function panierListe(): Response
    {
        return $this->render('panier/afficher.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    public function incrementer(): Response
    {
        return $this->render('panier/afficher.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    public function decrementer(): Response
    {
        return $this->render('panier/afficher.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    public function creer(): Response
    {
        return $this->render('panier/afficher.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    public function supprimer(): Response
    {
        return $this->render('panier/afficher.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    public function modifier(): Response
    {
        return $this->render('panier/afficher.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }
}
