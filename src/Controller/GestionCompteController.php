<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Form\UserType;
use App\Entity\Adresse;
use App\Form\ClientType;
use App\Service\ToolBox;
use App\Form\AdresseType;
use App\Form\CreerCompteType;
use App\Repository\AdresseTypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @Route("/compte/modifier/user/{id}", name="compte_modifier_user")
     */
    public function compteModifierEmail(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        //dd($form);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('compte_afficher', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte/creer", name="compte_creer")
     */
    public function compteCreer(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user = new User();
        $form = $this->createForm(CreerCompteType::class);


        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('/categorie', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gestion_compte/creer.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);




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
