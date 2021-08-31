<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionCommandesController extends AbstractController
{
    /**
     * @Route("/commande/commander", name="commande_creer")
     */
    public function commandeCreer(): Response
    {
        return $this->render('gestion_commandes/creer.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/commande/annuler", name="commande_annuler")
     */
    public function commandeAnnuler(): Response
    {
        return $this->render('gestion_commandes/annuler.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/commande/modifier", name="commande_modifier")
     */
    public function commandeModifier(): Response
    {
        return $this->render('gestion_commandes/modifier.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/commande/afficher", name="commande_afficher")
     */
    public function commandeAfficher(): Response
    {
        return $this->render('gestion_commandes/afficher.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

}
