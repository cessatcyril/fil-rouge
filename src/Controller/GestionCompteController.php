<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Service\ToolBox;
use App\Entity\AdresseType;
use App\Repository\AdresseTypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GestionCompteController extends AbstractController
{

    /**
     * @Route("/particulier/compte/afficher", name="compte_afficher")
     */
    public function compteAfficher(AdresseTypeRepository $adresseType, ToolBox $tb): Response
    {
        $obj = $this->getUser()->getClient();
        $adresse = $tb->getAdresses($this->getUser());
        $mail = $this->getUser()->getEmail();
        //dd($adresse);
        //////////////////////////////////////////////
        //                                          //
        //  AJOUTER L'AFFICHAGE HISTORIQUE COMMANDE //
        //                                          //
        //////////////////////////////////////////////
        return $this->render('gestion_compte/afficher.html.twig', [
            'infoClient' => $obj,
            'adresse' => $adresse,
            'email' => $mail,
        ]);
    }

    /**
     * @Route("/compte/modifier/{id}", name="compte_modifier")
     */
    public function compteModifier(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('compte_afficher', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/compte/modifier/password", name="compte_modifier_password")
     */
    public function compteModifierPassword(): Response
    {
        return $this->render('gestion_compte/modifierPassword.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/compte/modifier/email", name="compte_modifier_email")
     */
    public function compteModifierEmail(): Response
    {
        return $this->render('gestion_compte/modifierEmail.html.twig', [
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
