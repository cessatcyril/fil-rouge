<?php

namespace App\Controller;

use DateTime;
use App\Service\ToolBox;
use App\Form\VirementType;
use App\Form\CarteCreditType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\GestionCommandesController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementController extends AbstractController
{
    /**
     * @Route("/particulier/paiement/moyen_de_paiement/{id}", name="paiement_moyen")
     */
    public function paiementMoyen(CommandeRepository $commandeRepo, $id): Response
    {
        $commande = $commandeRepo->findOneBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);

        if ($commande==null) {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_COMMANDE_INCONNUE
            ]);
        }

        if ($commande->getComAnnulation()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_PAIEMENT_COMMANDE_ANNULEE
            ]);    
        }

        if ($commande->getComPaiement()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_PAIEMENT_DEJA_FAIT
            ]);
        }

        return $this->render('paiement/moyen.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/particulier/paiement/moyen_de_paiement/carte_de_credit/{id}", name="paiement_carte")
     */
    public function paiementCarte(CommandeRepository $commandeRepo, Request $request, $id): Response
    {
        $commande = $commandeRepo->findOneBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);

        if ($commande==null) {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_COMMANDE_INCONNUE
            ]);
        }

        if ($commande->getComAnnulation()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_PAIEMENT_COMMANDE_ANNULEE
            ]);    
        }

        if ($commande->getComPaiement()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_PAIEMENT_DEJA_FAIT
            ]);
        }

        $form = $this->createForm(CarteCreditType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('commande_succes', [
                'id' => $id
            ]);
        }
        
        return $this->render('paiement/carte.html.twig', [
            'id' => $id,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/particulier/paiement/moyen_de_paiement/virement/{id}", name="paiement_virement")
     */
    public function paiementVirement(CommandeRepository $commandeRepo, $id): Response
    {
        $commande = $commandeRepo->findOneBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);

        if ($commande==null) {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_COMMANDE_INCONNUE
            ]);
        }

        if ($commande->getComAnnulation()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_PAIEMENT_COMMANDE_ANNULEE
            ]);    
        }

        if ($commande->getComPaiement()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_PAIEMENT_DEJA_FAIT
            ]);
        }

        return $this->render('paiement/virement.html.twig', [
            'id' => $id,
        ]);
    }

    /**
     * @Route("/particulier/paiement/moyen_de_paiement/paypal/{id}", name="paiement_paypal")
     */
    public function paiementPaypal(CommandeRepository $commandeRepo, Request $request, $id): Response
    {
        $commande = $commandeRepo->findOneBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);

        if ($commande==null) {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_COMMANDE_INCONNUE
            ]);
        }

        if ($commande->getComAnnulation()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_PAIEMENT_COMMANDE_ANNULEE
            ]);    
        }

        if ($commande->getComPaiement()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_PAIEMENT_DEJA_FAIT
            ]);
        }

        $form = $this->createForm(PaypalType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('commande_succes', [
                'id' => $id
            ]);
        }
        return $this->render('paiement/paypal.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/particulier/commande/annulation/remboursement/succes", name="remboursement_succes")
     */
    public function remboursementSucces(): Response
    {
        return $this->render('paiement/remboursement_succes.html.twig', []);
    }

    /**
     * @Route("/particulier/commande/annulation/remboursement/{id}", name="remboursement_moyen")
     */
    public function remboursementMoyen(EntityManagerInterface $eMI, CommandeRepository $commandeRepo, ToolBox $toolBox, $id): Response
    {
        $commande = $commandeRepo->findOneBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);

        if ($commande==null) {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_COMMANDE_INCONNUE
            ]);
        }

        if (!$toolBox->intervalCorrect($commande->getComCommande(), GestionCommandesController::NB_HEURES_REMBOURSEMENT)) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_DATE_IMPOSSIBLE
            ]);
        }

        if (!$commande->getComAnnulation()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_PAS_EFFECTUEE
            ]);    
        }

        if (!$commande->getComPaiement()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_PAS_PAYE
            ]);
        }

        return $this->render('paiement/remboursement_moyen.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/particulier/commande/annulation/remboursement/carte/{id}", name="remboursement_carte")
     */
    public function remboursementCarte(Request $request, CommandeRepository $commandeRepo,ToolBox $toolBox, $id): Response
    {
        $commande = $commandeRepo->findOneBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);

        if ($commande==null) {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_COMMANDE_INCONNUE
            ]);
        }

        if (!$toolBox->intervalCorrect($commande->getComCommande(), GestionCommandesController::NB_HEURES_REMBOURSEMENT)) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_DATE_IMPOSSIBLE
            ]);
        }

        if (!$commande->getComAnnulation()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_PAS_EFFECTUEE
            ]);    
        }

        if (!$commande->getComPaiement()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_PAS_PAYE
            ]);
        }

        $form = $this->createForm(CarteCreditType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('paiement/remboursement_succes.html.twig', []);
        } else {
            return $this->render('paiement/remboursement_carte.html.twig', [
                'id' => $id,
                'form' => $form->createView()
            ]);
        }
    }


    /**
     * @Route("/particulier/commande/annulation/remboursement/virement/{id}", name="remboursement_virement")
     */
    public function remboursementVirement(Request $request, CommandeRepository $commandeRepo,ToolBox $toolBox, $id): Response
    {
        $commande = $commandeRepo->findOneBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);

        if ($commande==null) {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_COMMANDE_INCONNUE
            ]);
        }

        if (!$toolBox->intervalCorrect($commande->getComCommande(), GestionCommandesController::NB_HEURES_REMBOURSEMENT)) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_DATE_IMPOSSIBLE
            ]);
        }

        if (!$commande->getComAnnulation()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_PAS_EFFECTUEE
            ]);    
        }

        if (!$commande->getComPaiement()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_PAS_PAYE
            ]);
        }

        $form = $this->createForm(VirementType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('paiement/remboursement_succes.html.twig', []);
        } else {
            return $this->render('paiement/remboursement_virement.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/particulier/commande/annulation/remboursement/paypal/{id}", name="remboursement_paypal")
     */
    public function remboursementPaypal(Request $request, CommandeRepository $commandeRepo,ToolBox $toolBox, $id): Response
    {
        $commande = $commandeRepo->findOneBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);

        if ($commande==null) {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_COMMANDE_INCONNUE
            ]);
        }

        if (!$toolBox->intervalCorrect($commande->getComCommande(), GestionCommandesController::NB_HEURES_REMBOURSEMENT)) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_DATE_IMPOSSIBLE
            ]);
        }

        if (!$commande->getComAnnulation()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_PAS_EFFECTUEE
            ]);    
        }

        if (!$commande->getComPaiement()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_PAS_PAYE
            ]);
        }

        $form = $this->createForm(VirementType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('paiement/remboursement_succes.html.twig', []);
        } else {
            return $this->render('paiement/remboursement_paypal.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

}
