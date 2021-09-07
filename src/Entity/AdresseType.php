<?php

namespace App\Entity;

use App\Repository\AdresseTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdresseTypeRepository::class)
 */
class AdresseType
{
    const TYPES = [
        "domicile" => 1,
        "livraison" => 2,
        "facturation" => 3
    ];

    const DOMICILE = 1;
    const LIVRAISON = 2;
    const FACTURATION = 3;


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $typAdresse;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="adresseTypes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="adresseTypes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypAdresse(): ?int
    {
        return $this->typAdresse;
    }

    public function setTypAdresse(int $typAdresse): self
    {
        $this->typAdresse = $typAdresse;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
