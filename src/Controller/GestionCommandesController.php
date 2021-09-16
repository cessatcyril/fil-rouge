<?php

namespace App\Controller;

use DateTime;
use App\Entity\Commande;
use App\Service\ToolBox;
use App\Entity\CommandeDetail;
use App\Entity\Livraison;
use App\Entity\LivraisonDetail;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AdresseTypeRepository;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use DateInterval;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function PHPUnit\Framework\isNull;

class GestionCommandesController extends AbstractController
{
    const INTERVALLE_DATE_BUTOIR = 'P15D';
    const INTERVALLE_DATE_LIVRAISON = 'P2D';
    const NB_JOURS_REMBOURSEMENT = 1;


    /**
     * @Route("/particulier/commande/commander", name="commande_creer")
     */
    public function commandeCreer(EntityManagerInterface $eMI, ProduitRepository $produitRepo, ToolBox $toolBox): Response
    {
        //mise en base de donnees
        //pdf facture

        $panier = $toolBox->getPanier($this->getSession());
        if ($panier==null) {
            return $this->redirectToRoute("panier_vide");
        }

        $date = $this->getDate();
        $dateButoir = $this->getDateButoir($date);
        $dateLivraisonPrevue = $this->getDateLivraisonPrevue($date);

        $commande = new Commande();
        $commande->setClient($this->getUser()->getClient());
        $commande->setComStatut(Commande::EN_COURS);
        $commande->setComCommande($date);
        $commande->setComButoir($dateButoir);
        if ($eMI->persist($commande) || $eMI->flush()) {
            return $this->redirectToRoute("commande_erreur");
        }

        $commande_id = $commande->getId();
        $commande_client = $commande->getClient()->getId();
        $commande->setComFiche($this->getFiche($commande_id, $commande_client));
        $commande->setComFacture($this->getFacture($commande_id, $commande_client));
        if ($eMI->persist($commande) || $eMI->flush()) {
            return $this->redirectToRoute("commande_erreur");
        }

        foreach ($panier as $key => $article) {
            $produit = $produitRepo->findOneBy(['id' => $article["id"]]);
            $commande_detail = new CommandeDetail();
            $commande_detail->setCommande($commande);
            $commande_detail->setProduit($produit);
            $commande_detail->setDetQuantite($article["quantite"]);
            $commande_detail->setDetPrixVente($article["prix"]);
            $commande_detail->setDetRemise(0);//Ajouter variable "remise" dans panier
            if ($eMI->persist($commande_detail)) {
                return $this->redirectToRoute("commande_erreur");
            }

            $livraison = new Livraison();
            $livraison->setCommande($commande);
            $livraison->setLivDate($dateLivraisonPrevue);
            if ($eMI->persist($livraison)) {
                return $this->redirectToRoute("commande_erreur");
            }

            $livraisonDetail = new LivraisonDetail();
            $livraisonDetail->setProduit($produit);
            $livraisonDetail->setLivraison($livraison);
            $livraisonDetail->setDetQuantiteLivree(0);
            if ($eMI->persist($livraisonDetail)) {
                return $this->redirectToRoute("commande_erreur");
            }
            $eMI->flush();
        }

        //(try/catch ou if) ? redirectToRoute(succes) : redirectToRoute(erreur{message})

        return $this->render('gestion_commandes/creer.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("commande/erreur", name="commande_erreur")
     */
    public function commandeErreur(): Response
    {
        return $this->render('gestion_commandes/erreur.html.twig', [
            'message' => 'Une erreur s\'est produite lors de la commande, veuillez ré-essayer.'
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
     * @Route("/particulier/commande/annulation/{id}", name="commande_annuler")
     */
    public function commandeAnnuler(CommandeRepository $commandeRepo, $id): Response
    {
        $commande = $commandeRepo->findOneBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);

        if ($commande==null) {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'id' => $id
            ]);
        }

        $maintenant = new DateTime();
        $maintenant->format("Y-m-d H:i:s");

        $dateCommande = DateTime::createFromFormat("Y-m-d H:i:s", $commande->getComCommande()->format("Y-m-d H:i:s"));    
        $intervalle = $dateCommande->diff($maintenant);

        if ($intervalle->format('%R') === "+" || $intervalle->format('%d') < GestionCommandesController::NB_JOURS_REMBOURSEMENT) {
            //Dans Commande, creer attribut annulation
            //$commande->getAnnulation();
        } else {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'id' => $id
            ]);
        }


        /*
            Client clique sur annuler commande
                si comDate < 24h
                    Client est redirige sur la page de remboursement
                    Remboursement par carte bancaire ou virement
                    Client clique sur remboursement
                    Client est redirige vers commande_annuler
                    Changements dans la bdd :
                        ajout d'un booleen : 
                            si true >> commande pas affichee sinon affichee
                            si true >> commande a déja été remboursée
                    redirection vers la page de succes ou la page d'erreur
                sinon redirection vers page reglement#remboursement
        */


        return $this->render('gestion_commandes/annuler.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("/particulier/commande/liste", name="commande_lister")
     */
    public function commandeLister(CommandeRepository $commandeRepo): Response
    {
        $commandes = $commandeRepo->findBy(['client'=>$this->getUser()->getCLient()->getId()]);
        $donnees = [];
        foreach ($commandes as $key => $commande) {
            $donnees[$key]['id'] = $commande->getId();
            $donnees[$key]['date_commande'] = $commande->getComCommande()->format('d/m/Y');
            $donnees[$key]['date_livraison'] = (is_Null($commande->getComLivraison())) ? "Pas encore livré." : $commande->getComLivraison()->format('d/m/Y');

            
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

                $livraisonDetails = $livraison->getLivraisonDetails();
                foreach ($livraisonDetails as $key3 => $livraisonDetail) {
                    if ($livraisonDetail->getLivraison() === $commande->getId()) {
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_livree'] = (is_Null($livraisonDetail->getDetQuantiteLivree() ? 0 : $livraisonDetail->getDetQuantiteLivree()));
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_a_livrer'] = $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_commandee'] - $donnees[$key]['livraison'][$key3]['quantite_livree'] = $livraisonDetail->getDetQuantiteLivree();
                    } else {
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_livree'] = 0;
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_a_livrer'] = $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['quantite_commandee'];
                    }
                }
            }
        }
        //dd($donnees);

        return $this->render('gestion_commandes/liste.html.twig', [
            'controller_name' => 'GestionCompteController',
            'commandes' => $donnees
        ]);
    }


    /**
     * @Route("/particulier/commande/detail/{id}", name="commande_detail")
     */
    public function commandeDetail(CommandeRepository $commandeRepo, $id): Response
    {
        $commandes = $commandeRepo->findBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);
        $donnees = [];
        foreach ($commandes as $key => $commande) {
            $donnees[$key]['id'] = $commande->getId();
            $donnees[$key]['date_commande'] = $commande->getComCommande()->format('d/m/Y');
            $donnees[$key]['date_livraison'] = (is_Null($commande->getComLivraison())) ? "Pas encore livré." : $commande->getComLivraison()->format('d/m/Y');

            
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

                $livraisonDetails = $livraison->getLivraisonDetails();
                foreach ($livraisonDetails as $key3 => $livraisonDetail) {
                    if ($livraisonDetail->getLivraison() === $commande->getId()) {
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_livree'] = (is_Null($livraisonDetail->getDetQuantiteLivree() ? 0 : $livraisonDetail->getDetQuantiteLivree()));
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_a_livrer'] = $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_commandee'] - $donnees[$key]['livraison'][$key3]['quantite_livree'] = $livraisonDetail->getDetQuantiteLivree();
                    } else {
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_livree'] = 0;
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_a_livrer'] = $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['quantite_commandee'];
                    }
                }
            }
        }
        //dd($donnees);

        return $this->render('gestion_commandes/detail.html.twig', [
            'controller_name' => 'GestionCompteController',
            'commandes' => $donnees
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

    public function getDate()
    {
        $date = new DateTime();
        $date->format("Y-m-d H:i:s");
        return $date;
    }

    public function getDateButoir($dateCommande)
    {
        $date = $dateCommande->add(new DateInterval(GestionCommandesController::INTERVALLE_DATE_BUTOIR));
        $date->format("Y-m-d H:i:s");
        return $date;
    }

    public function getDateLivraisonPrevue($dateCommande)
    {
        $date = $dateCommande->add(new DateInterval(GestionCommandesController::INTERVALLE_DATE_LIVRAISON));
        $date->format("Y-m-d H:i:s");
        return $date;
    }

    public function getFiche($commandeId, $clientId)
    {
        return "Commande_".$clientId."-".$commandeId;
    }

    public function getFacture($commandeId, $clientId)
    {
        return "Facture_".$clientId."-".$commandeId;
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
