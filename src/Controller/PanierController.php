<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier/liste", name="panier_liste")
     */
    public function panierListe(Session $session): Response
    {
        $panier = $session->get("panier");
        //$test = $panier[0]["id"];

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

        $session->set("panier", $panier);

        if ($panier == null) {
            return $this->redirectToRoute("panier_vide");
        } else {


            return $this->render('panier/afficher.html.twig', [
                'controller_name' => 'PanierController',
                "panier" => $panier
            ]);
        }
    }

    /**
     * @Route("/panier/vide", name="panier_vide")
     */
    public function paniervide(): Response
    {
        return $this->render('panier/panierVide.html.twig', [
            'controller_name' => 'PanierVideController',
        ]);
    }

    /**
     * @Route("/panier/raz", name="panier_raz")
     */
    public function panierRaz(SessionInterface $session): Response
    {
        $session->remove("panier");
        $session->set("panier", []);

        return $this->render('panier/afficher.html.twig', [
            'controller_name' => 'PanierController',
            "panier" => []
        ]);
    }

    /**
     * @Route("/panier/ajouter/{id}", name="panier_ajouter")
     */
    public function ajouter(Produit $id, Session $session): Response
    {

        //$panierNon = $id->getId();
        //$session->set($panierNon, $id);
        $panier = $session->get("panier");
        if ($panier == null) $panier = [];

        $trouve = -1;
        foreach ($panier as $i => $ligne) {
            if ($ligne["id"] == $id->getId()) {
                $trouve = $i;
            }
        }

        if ($trouve == -1) {
            $elt = [
                "quantite" => 1,
                "id" => $id->getId(),
                "nom" => $id->getProProduit(),
                "accroche" => $id->getProAccroche(),
                "imageNom" => $id->getImagePrincipale(),
                "prix" => $id->getProPrixV(),
                "prixTotal" => 0,
                "prixCommande" => 0,
            ];
            $panier[] = $elt;
        } else {
            $panier[$trouve]["quantite"]++;
        }
        $session->set("panier", $panier);

        //dd($panier);
        return $this->redirectToRoute("panier_liste");

        // return $this->render('panier/afficher.html.twig', [
        //     'controller_name' => 'PanierController',
        //     "panier" => $panier
        // ]);
    }

    /**
     * @Route("/panier/supprimer/{produit}", name="panier_supprimer")
     */
    public function supprimer(Produit $produit, Session $session): Response
    {
        $panier = $session->get("panier");

        $nouveau = [];
        foreach ($panier as $ligne) {
            if ($ligne["id"] != $produit->getId()) {
                $nouveau[] = $ligne;
            }
        }
        $session->set("panier", $nouveau);

        return $this->redirectToRoute("panier_liste");
    }

    /**
     * @Route("/panier/modifier/{id}", name="panier_modifier")
     */
    public function modifier(): Response
    {
        return $this->render('panier/afficher.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    /**
     * @Route("/panier/reduire/{produit}", name="panier_reduire")
     */
    public function reduire(Produit $produit, Session $session): Response
    {

        //$panierNon = $id->getId();
        //$session->set($panierNon, $id);
        $panier = $session->get("panier");
        if ($panier == null) $panier = [];

        $trouve = -1;
        foreach ($panier as $i => $ligne) {
            if ($ligne["id"] == $produit->getId()) {
                $trouve = $i;
            }
        }

        if ($trouve != -1) {
            $panier[$trouve]["quantite"]--;
        }
        $session->set("panier", $panier);

        //dd($panier);
        return $this->redirectToRoute("panier_liste");
    }
}
