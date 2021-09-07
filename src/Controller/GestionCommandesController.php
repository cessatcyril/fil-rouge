<?php

namespace App\Controller;

use App\Entity\AdresseType;
use App\Form\CarteCreditType;
use App\Repository\AdresseTypeRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Service\ToolBox;

class GestionCommandesController extends AbstractController
{
    private $adresseRepository;

    public function __construct(AdresseTypeRepository $adresseRepository)
    {
        $this->adresseRepository = $adresseRepository;
    }

    /**
     * @Route("/commande/commander", name="commande_creer")
     */
    public function commandeCreer(): Response
    {
        //creer commande
        //recap'
        //mise en base de donnees
        //pdf

        return $this->render('gestion_commandes/creer.html.twig', [
            'controller_name' => 'GestionCompteController',
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
    public function commandeRecapitulatif(AdresseTypeRepository $repo, ToolBox $tb): Response
    {
        return $this->render('gestion_commandes/recapitulatif.html.twig', [
            'controller_name' => 'GestionCompteController',
            'panier' => $this->getPanier(),
            'adresses' => $tb->getAdresses($this->getUser())
        ]);
    }

    public function getPanier()
    {
        $panier = $this->getSession()->get("panier");
        //$test = $panier[0]["id"];
        if ($panier == null) {
            return $this->redirectToRoute("panier_vide");
        }

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
        $this->getSession()->set("panier", $panier);

        return $panier;
    }

    // public function getAdresses()
    // {
    //     $adresses = [
    //         "domicile"=>$this->getAdresseRepository()->findOneBy(['typAdresse'=>AdresseType::TYPES['domicile'], 'client'=>$this->getUser()->getClient()]),
    //         "livraison"=>$this->getAdresseRepository()->findOneBy(['typAdresse'=>AdresseType::TYPES['livraison'], 'client'=>$this->getUser()->getClient()]),
    //         "facturation"=>$this->getAdresseRepository()->findOneBy(['typAdresse'=>AdresseType::TYPES['facturation'], 'client'=>$this->getUser()->getClient()])
    //     ];
    //     return $adresses;
    // }


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

    /**
     * Get the value of adresseRepository
     */
    public function getAdresseRepository()
    {
        return $this->adresseRepository;
    }

    /**
     * Set the value of adresseRepository
     *
     * @return  self
     */
    public function setAdresseRepository($value)
    {
        $this->adresseRepository = $value;

        return $this;
    }
}
