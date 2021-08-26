<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
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
    private $entNom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $entPays;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $entVille;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entAdresse;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $entPostal;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $entSiret;

    public function __construct()
    {
        $this->Client = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntNom(): ?string
    {
        return $this->entNom;
    }

    public function setEntNom(string $entNom): self
    {
        $this->entNom = $entNom;

        return $this;
    }

    public function getEntPays(): ?string
    {
        return $this->entPays;
    }

    public function setEntPays(string $entPays): self
    {
        $this->entPays = $entPays;

        return $this;
    }

    public function getEntVille(): ?string
    {
        return $this->entVille;
    }

    public function setEntVille(string $entVille): self
    {
        $this->entVille = $entVille;

        return $this;
    }

    public function getEntAdresse(): ?string
    {
        return $this->entAdresse;
    }

    public function setEntAdresse(string $entAdresse): self
    {
        $this->entAdresse = $entAdresse;

        return $this;
    }

    public function getEntPostal(): ?string
    {
        return $this->entPostal;
    }

    public function setEntPostal(string $entPostal): self
    {
        $this->entPostal = $entPostal;

        return $this;
    }

    public function getEntSiret(): ?string
    {
        return $this->entSiret;
    }

    public function setEntSiret(string $entSiret): self
    {
        $this->entSiret = $entSiret;

        return $this;
    }
}
