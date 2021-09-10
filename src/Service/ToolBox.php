<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\AdresseType;
use App\Repository\AdresseTypeRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;



class ToolBox
{
    use ControllerTrait;
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
        $session->set("panier", $panier);

        return $panier;
    }
}
