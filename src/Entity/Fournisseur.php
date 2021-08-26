<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FournisseurRepository::class)
 */
class Fournisseur
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
    private $fouNom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fouAdresse;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $fouPostal;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $fouVille;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $fouPays;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $fouTel;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $fouFax;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fouDate;

    /**
     * @ORM\ManyToMany(targetEntity=Produit::class, mappedBy="fournisseurs")
     */
    private $produits;

    public function __construct()
    {
        $this->ContactFournisseur = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFouNom(): ?string
    {
        return $this->fouNom;
    }

    public function setFouNom(string $fouNom): self
    {
        $this->fouNom = $fouNom;

        return $this;
    }

    public function getFouAdresse(): ?string
    {
        return $this->fouAdresse;
    }

    public function setFouAdresse(string $fouAdresse): self
    {
        $this->fouAdresse = $fouAdresse;

        return $this;
    }

    public function getFouPostal(): ?string
    {
        return $this->fouPostal;
    }

    public function setFouPostal(string $fouPostal): self
    {
        $this->fouPostal = $fouPostal;

        return $this;
    }

    public function getFouVille(): ?string
    {
        return $this->fouVille;
    }

    public function setFouVille(string $fouVille): self
    {
        $this->fouVille = $fouVille;

        return $this;
    }

    public function getFouPays(): ?string
    {
        return $this->fouPays;
    }

    public function setFouPays(string $fouPays): self
    {
        $this->fouPays = $fouPays;

        return $this;
    }

    public function getFouTel(): ?string
    {
        return $this->fouTel;
    }

    public function setFouTel(?string $fouTel): self
    {
        $this->fouTel = $fouTel;

        return $this;
    }

    public function getFouFax(): ?string
    {
        return $this->fouFax;
    }

    public function setFouFax(?string $fouFax): self
    {
        $this->fouFax = $fouFax;

        return $this;
    }

    public function getFouDate(): ?\DateTimeInterface
    {
        return $this->fouDate;
    }

    public function setFouDate(\DateTimeInterface $fouDate): self
    {
        $this->fouDate = $fouDate;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }
}
