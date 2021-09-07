<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=AdresseType::class, mappedBy="adresse")
     */
    private $adresseTypes;

    public function __construct()
    {
        $this->adresseTypes = new ArrayCollection();
    }

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

    /**
     * @return Collection|AdresseType[]
     */
    public function getAdresseTypes(): Collection
    {
        return $this->adresseTypes;
    }

    public function addAdresseType(AdresseType $adresseType): self
    {
        if (!$this->adresseTypes->contains($adresseType)) {
            $this->adresseTypes[] = $adresseType;
            $adresseType->setAdresse($this);
        }

        return $this;
    }

    public function removeAdresseType(AdresseType $adresseType): self
    {
        if ($this->adresseTypes->removeElement($adresseType)) {
            // set the owning side to null (unless already changed)
            if ($adresseType->getAdresse() === $this) {
                $adresseType->setAdresse(null);
            }
        }

        return $this;
    }
}
