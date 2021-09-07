<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\AdresseType;
use App\Repository\AdresseTypeRepository;



class ToolBox
{
    private $at_repo;

    public function __construct(AdresseTypeRepository $at_repo)
    {
        $this->at_repo = $at_repo;
    }


    public function getAdresses(User $user)
    {
        $adresses = [
            "domicile" => $this->at_repo->findOneBy(['typAdresse' => AdresseType::DOMICILE, 'client' => $user->getClient()]),
            "livraison" => $this->at_repo->findOneBy(['typAdresse' => AdresseType::TYPES['livraison'], 'client' => $user->getClient()]),
            "facturation" => $this->at_repo->findOneBy(['typAdresse' => AdresseType::TYPES['facturation'], 'client' => $user->getClient()])
        ];
        return $adresses;
    }
}
