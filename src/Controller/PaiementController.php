<?php

namespace App\Controller;

use App\Form\CarteCreditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementController extends AbstractController
{
    /**
     * @Route("/particulier/paiement/moyen_de_paiement", name="paiement_moyen")
     */
    public function paiementMoyen(): Response
    {
        return $this->render('paiement/moyen.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/particulier/paiement/moyen_de_paiement/carte_de_credit", name="paiement_carte")
     */
    public function paiementCarte(Request $request): Response
    {
        $form = $this->createForm(CarteCreditType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('commande_creer');
        }

        return $this->render('paiement/carte.html.twig', [
            'controller_name' => 'GestionCompteController',
            'form' => $form->createView()
        ]);
    }

    /**
     * A SUPPRIMER SI PAS DE FORMULAIRE DANS virement.html.twig
     * @Route("/particulier/paiement/moyen_de_paiement/virement", name="paiement_virement")
     */
    public function paiementVirement(): Response
    {
        return $this->render('paiement/virement.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * A SUPPRIMER SI PAS DE FORMULAIRE DANS paypal.html.twig
     * @Route("/particulier/paiement/moyen_de_paiement/paypal", name="paiement_paypal")
     */
    public function paiementPaypal(): Response
    {
        return $this->render('paiement/paypal.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/particulier/commande/annulation/remboursement/{id}", name="remboursement_moyen")
     */
    public function remboursementMoyen($id): Response
    {
        //dd($id);

        return $this->render('paiement/remboursement_moyen.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/particulier/commande/annulation/remboursement/carte/{id}", name="remboursement_carte")
     */
    public function remboursementCarte(Request $request, $id): Response
    {
        $form = $this->createForm(CarteCreditType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('commande_creer');
        }

        return $this->render('paiement/remboursement_carte.html.twig', [
            'id' => $id,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/particulier/commande/annulation/remboursement/virement/{id}", name="remboursement_virement")
     */
    public function remboursementVirement($id): Response
    {
        return $this->render('paiement/remboursement_virement.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/particulier/commande/annulation/remboursement/paypal/{id}", name="remboursement_paypal")
     */
    public function remboursementPaypal($id): Response
    {
        return $this->render('paiement/remboursement_paypal.html.twig', [
            'id' => $id
        ]);
    }

}
