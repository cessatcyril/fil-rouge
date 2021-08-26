<?php

namespace App\Entity;

use App\Repository\LivraisonDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivraisonDetailRepository::class)
 */
class LivraisonDetail
{
    /**
     * @ORM\Column(type="integer")
     */
    private $detQuantiteLivree;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Livraison::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $livraison;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Produit::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;


    public function getDetQuantiteLivree(): ?int
    {
        return $this->detQuantiteLivree;
    }

    public function setDetQuantiteLivree(int $detQuantiteLivree): self
    {
        $this->detQuantiteLivree = $detQuantiteLivree;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

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
