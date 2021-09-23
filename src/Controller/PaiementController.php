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
     * @Route("/particulier/paiement/moyen_de_paiement/virement", name="paiement_virement")
     */
    public function paiementVirement(Request $request): Response
    {
        $form = $this->createForm(VirementType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('commande_creer');
        }
        return $this->render('paiement/virement.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/particulier/paiement/moyen_de_paiement/paypal", name="paiement_paypal")
     */
    public function paiementPaypal(Request $request): Response
    {
        $form = $this->createForm(PaypalType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('commande_creer');
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
