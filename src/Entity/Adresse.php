<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adrPays;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adrVille;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $adrPostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adrAdresse;

    /**
     * @ORM\ManyToOne(targetEntity=AdresseType::class, inversedBy="adresse")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresseType;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdrPays(): ?string
    {
        return $this->adrPays;
    }

    public function setAdrPays(string $adrPays): self
    {
        $this->adrPays = $adrPays;

        return $this;
    }

    public function getAdrVille(): ?string
    {
        return $this->adrVille;
    }

    public function setAdrVille(string $adrVille): self
    {
        $this->adrVille = $adrVille;

        return $this;
    }

    public function getAdrPostal(): ?string
    {
        return $this->adrPostal;
    }

    public function setAdrPostal(string $adrPostal): self
    {
        $this->adrPostal = $adrPostal;

        return $this;
    }

    public function getAdrAdresse(): ?string
    {
        return $this->adrAdresse;
    }

    public function setAdrAdresse(string $adrAdresse): self
    {
        $this->adrAdresse = $adrAdresse;

        return $this;
    }

    public function getAdresseType(): ?AdresseType
    {
        return $this->adresseType;
    }

    public function setAdresseType(?AdresseType $adresseType): self
    {
        $this->adresseType = $adresseType;

        return $this;
    }
}
