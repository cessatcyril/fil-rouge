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
     * @ORM\ManyToOne(targetEntity=Commande::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\Column(type="integer")
     */
    private $detQuantite;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Produit::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
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

    public function getDetQuantite(): ?int
    {
        return $this->detQuantite;
    }

    public function setDetQuantite(int $detQuantite): self
    {
        $this->detQuantite = $detQuantite;

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
}
