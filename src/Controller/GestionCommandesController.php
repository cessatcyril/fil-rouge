<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Service\ToolBox;
use App\Form\CommandeType;
use App\Entity\CommandeDetail;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AdresseTypeRepository;
use App\Repository\CommandeDetailRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GestionCommandesController extends AbstractController
{

    /**
     * @Route("/particulier/commande/commander", name="commande_creer")
     */
    public function commandeCreer(EntityManagerInterface $eMI, CommandeRepository $commandeRepo, CommandeDetailRepository $commandeDetailRepository, Toolbox $toolBox): Response
    {
        //mise en base de donnees
        //pdf facture

        
        $panier = $toolBox->getPanier($this->getSession());
        //dd($panier);
        if ($panier==null) {
            return $this->redirectToRoute("panier_vide");
        }
        

        //(try/catch ou if) ? redirectToRoute(succes) : redirectToRoute(erreur{message})
        $commande = new Commande();
        $commande->setClient($this->getUser()->getClient()->getId());
        //$eMI->persist($commande);
        //$eMI->flush();


        return $this->render('gestion_commandes/creer.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("commande/passee", name="commande_passee")
     */
    public function FunctionName(): Response
    {
        return $this->render('gestion_commandes/passee.html.twig', [
            ////////////////////////////////////////////////////////////////////////////////
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
     * @Route("/particulier/commande/liste", name="commande_lister")
     */
    public function commandeLister(): Response
    {
        return $this->render('gestion_commandes/liste.html.twig', [
            'controller_name' => 'GestionCompteController',
            'commandes' =>$this->getListe()
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
    public function commandeRecapitulatif(AdresseTypeRepository $repo, ToolBox $toolBox): Response
    {
        return $this->render('gestion_commandes/recapitulatif.html.twig', [
            'controller_name' => 'GestionCompteController',
            'panier' => $toolBox->getPanier($this->getSession()),
            'adresses' => $toolBox->getAdresses($this->getUser())
        ]);
    }

    public function getListe()
    {
        $commandes = $this->getUser()->getClient()->getCommande();
        $donnees = [];
        foreach ($commandes as $key => $commande) {
            $donnees[$key]['id'] = $commande->getId();
            $donnees[$key]['date_commande'] = $commande->getComCommande()->format('d/m/Y');
            $donnees[$key]['date_livraison'] = $commande->getComLivraison()->format('d/m/Y');

            
            $commande_details = $commande->getCommandeDetails();
            foreach ($commande_details as $key3 => $commande_detail) {
                $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['id_produit'] = $commande_detail->getProduit()->getId();
                $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['produit'] = $commande_detail->getProduit()->getProProduit();
                $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['accroche'] = $commande_detail->getProduit()->getProAccroche();
                $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['description'] = $commande_detail->getProduit()->getProDescription();
                $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['remise'] = $commande_detail->getDetRemise();
                $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['prix_unitaire'] = $commande_detail->getDetPrixVente();
                $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['quantite_commandee'] = $commande_detail->getDetQuantite();/////////////////////
                $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['sous_total'] = $commande_detail->getDetPrixVente() * $commande_detail->getDetQuantite() - $commande_detail->getDetRemise();
            }

            $livraisons = $commande->getLivraisons();
            foreach ($livraisons as $key2 => $livraison) {

                $livraison_detail = $livraison->getLivraisonDetails();
                foreach ($livraison_detail as $key4 => $livraison_detail) {
                    if (isset($donnees[$key]['produits'][$livraison_detail->getProduit()->getId()]['id_produit']) || isset($donnees[$key]['produits'][$livraison_detail->getProduit()->getId()]['quantite_commandee'])) {
                        $donnees[$key]['produits'][$livraison_detail->getProduit()->getId()]['quantite_livree'] = $livraison_detail->getDetQuantiteLivree();
                        $donnees[$key]['produits'][$livraison_detail->getProduit()->getId()]['quantite_a_livrer'] = $donnees[$key]['produits'][$livraison_detail->getProduit()->getId()]['quantite_commandee'] - $donnees[$key]['livraison'][$key4]['quantite_livree'] = $livraison_detail->getDetQuantiteLivree();
                    }
                }
            }
        }
        return $donnees;
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
