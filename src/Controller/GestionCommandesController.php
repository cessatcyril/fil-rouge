<?php

namespace App\Controller;

use App\Form\CarteCreditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionCommandesController extends AbstractController
{
    /**
     * @Route("/commande/moyen_de_paiement", name="commande_moyen")
     */
    public function commandeMoyen(): Response
    {
        return $this->render('gestion_commandes/moyen.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/commande/moyen_de_paiement/carte_de_credit", name="commande_carte")
     */
    public function commandeCarte(): Response
    {
        $form = $this->createForm(CarteCreditType::class);

        return $this->render('gestion_commandes/carte.html.twig', [
            'controller_name' => 'GestionCompteController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/commande/moyen_de_paiement/virement", name="commande_virement")
     */
    public function commandeVirement(): Response
    {
        return $this->render('gestion_commandes/virement.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/commande/moyen_de_paiement/paypal", name="commande_paypal")
     */
    public function commandePaypal(): Response
    {
        return $this->render('gestion_commandes/paypal.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    

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
