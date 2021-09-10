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
use App\Entity\AdresseType as AT;
use App\Repository\UserRepository;
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
        $userId = $this->getUser();
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
            'userId' => $userId,
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

        // $user = new User();
        $form = $this->createForm(CreerCompteType::class);
        $form->handleRequest($request);

        if ($request->isMethod("post")) {

            $data = $form->getData();
            // dd($data);

            $u = new User();
            $u->setEmail($data["email"]);

            $u->setPassword(
                $passwordEncoder->encodePassword(
                    $u,
                    $data["plainPassword"]
                )
            );

            $c = new Client();
            $c->setCliNom($data["cliNom"]);
            $u->setRoles(["ROLE_PARTICULIER"]);

            $c->setUser($u);

            $a1 = new Adresse();
            $a1->setAdrPays($data["adrPaysDomicile"]);

            $at1 = new AT();
            $at1->setClient($c);
            $at1->setAdresse($a1);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($u);
            $entityManager->persist($c);
            $entityManager->persist($a1);
            $entityManager->persist($at1);
            $entityManager->flush();

            return $this->redirectToRoute('/categorie', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gestion_compte/creer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/compte/supprimer/{id}", name="compte_supprimer")
     */
    public function compteSupprimer(User $user): Response
    {

        $em = $this->getDoctrine()->getManager();


        foreach ($user->getClient()->getAdresseTypes() as $at) {
            $em->remove($at->getAdresse());
            $em->remove($at);
        }

        $em->remove($user);

        $em->flush();

        return $this->render('gestion_compte/supprimer.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }
}
