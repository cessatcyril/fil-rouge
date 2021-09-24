<?php

namespace App\Service;

use DateTime;
use App\Entity\User;
use App\Entity\AdresseType;
use App\Repository\AdresseTypeRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class ToolBox
{
    // use ControllerTrait;
    private $adresseTypeRepository;

    public function __construct(AdresseTypeRepository $adresseTypeRepository)
    {
        $this->adresseTypeRepository = $adresseTypeRepository;
    }


    public function getAdresses(User $user)
    {
        $adresses = [
            "domicile" => $this->adresseTypeRepository->findOneBy(['typAdresse' => AdresseType::DOMICILE, 'client' => $user->getClient()]),
            "livraison" => $this->adresseTypeRepository->findOneBy(['typAdresse' => AdresseType::LIVRAISON, 'client' => $user->getClient()]),
            "facturation" => $this->adresseTypeRepository->findOneBy(['typAdresse' => AdresseType::FACTURATION, 'client' => $user->getClient()])
        ];
        return $adresses;
    }

    public function getPanier(Session $session)
    {
        $panier = $session->get("panier");
        //$test = $panier[0]["id"];
        if ($panier == null) {
            return null; // 
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
        $session->set("panier", $panier);

        return $panier;
    }

    public function panierRaz(SessionInterface $session)
    {
        $session->remove("panier");
        $session->set("panier", []);
    }

    public function intervalCorrect($date, $nombreDeJourMax)
    {
        $maintenant = new DateTime();
        $maintenant->format("Y-m-d H:i:s");

        $dateCommande = DateTime::createFromFormat("Y-m-d H:i:s", $date->format("Y-m-d H:i:s"));    
        $intervalle = $dateCommande->diff($maintenant);

        if ($intervalle->format('%R') === "+" && ($intervalle->format('%d')*24+$intervalle->format('%h')) < $nombreDeJourMax) {
            return true;
        } else {
            return false;
        }
    }
}
