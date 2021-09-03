<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionCompteController extends AbstractController
{

    /**
     * @Route("/particulier/compte/afficher", name="compte_afficher")
     */
    public function compteAfficher(): Response
    {
        return $this->render('gestion_compte/afficher.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/compte/modifier", name="compte_modifier")
     */
    public function compteModifier(): Response
    {
        return $this->render('gestion_compte/modifier.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/compte/creer", name="compte_creer")
     */
    public function compteCreer(): Response
    {
        return $this->render('gestion_compte/creer.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/compte/supprimer", name="compte_supprimer")
     */
    public function compteSupprimer(): Response
    {
        return $this->render('gestion_compte/supprimer.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }
}
