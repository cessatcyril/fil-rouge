<?php

namespace App\Entity;

use App\Repository\CommandeDetailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Produit;

/**
 * @ORM\Entity(repositoryClass=CommandeDetailRepository::class)
 */
class CommandeDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $detQuantite;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    private $detRemise;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    private $detPrixVente;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="commandeDetails")
     * @ORM\JoinColumn(nullable=true)
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="commandeDetails")
     * @ORM\JoinColumn(nullable=true)
     */
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetQuantite(): ?int
    {
        return $this->detQuantite;
    }

    public function setDetQuantite(int $detQuantite): self
    {
        $this->detQuantite = $detQuantite;

        return $this;
    }

    public function getDetRemise(): ?string
    {
        return $this->detRemise;
    }

    public function setDetRemise(string $detRemise): self
    {
        $this->detRemise = $detRemise;

        return $this;
    }

    public function getDetPrixVente(): ?string
    {
        return $this->detPrixVente;
    }

    public function setDetPrixVente(string $detPrixVente): self
    {
        $this->detPrixVente = $detPrixVente;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}
