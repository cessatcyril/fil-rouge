<?php

namespace App\Controller;

use App\Entity\AdresseType;
use App\Repository\AdresseTypeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GestionCompteController extends AbstractController
{

    /**
     * @Route("/particulier/compte/afficher", name="compte_afficher")
     */
    public function compteAfficher(AdresseTypeRepository $adresseType): Response
    {
        $obj = $this->getUser()->getClient();

        //$adresse = $this->getUser()->getClient()->getAdresseTypes();

        //dd($adresse);
        // $clientId = $this->getUser()->getClient()->getId();
        // $est = ["client" => $clientId];
        // //dd($est);
        // $adresseType->findby($est);
        // dd($adresseType->findby($est));
        return $this->render('gestion_compte//afficher.html.twig', [
            'infoClient' => $obj,
            //'adresse' => $adresse
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
