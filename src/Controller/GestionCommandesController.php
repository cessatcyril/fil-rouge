<?php

namespace App\Controller;

use App\Form\CarteCreditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;

class GestionCommandesController extends AbstractController
{

    /**
     * @Route("/commande/commander", name="commande_creer")
     */
    public function commandeCreer(): Response
    {
        //creer commande
        //recap'
        //mise en base de donnees
        //pdf

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

    /**
     * @Route("/particulier/commande/recapitulatif", name="commande_recapitulatif")
     */
    public function commandeRecapitulatif(): Response
    {
        $panier = $this->getPanier();
        $adressesClient = $this->getUser();//->getTypeAdresse(); ??

        return $this->render('gestion_commandes/recapitulatif.html.twig', [
            'controller_name' => 'GestionCompteController',
            'panier' => $panier,
            'infos_client' => $adressesClient
        ]);
    }

    public function getPanier()
    {
        $panier = $this->getSession()->get("panier");
        //$test = $panier[0]["id"];
        if ($panier == null) {
            return $this->redirectToRoute("panier_vide");
        }

        if ($panier != null) {
            foreach ($panier as $i => $ligne) {
                $panier[$i]["prixTotal"] = $panier[$i]["quantite"] * $panier[$i]["prix"];
            }
        }
        if ($panier != null) {
            $commande = 0;
            foreach ($panier as $i => $ligne) {
                $commande = $commande + $panier[$i]["prixTotal"];
                $panier[0]["prixCommande"] = $commande;
            }
        }
        $this->getSession()->set("panier", $panier);

        return $panier;
    }


    /**
     * Get the value of session
     */ 
    public function getSession()
    {
        return new Session();
    }

    /**
     * Set the value of session
     *
     * @return  self
     */ 
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }
}