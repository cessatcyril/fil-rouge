<?php

namespace App\Entity;

use App\Repository\LivraisonDetailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivraisonDetailRepository::class)
 */
class LivraisonDetail
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
    private $detQuantiteLivree;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="livraisonDetails")
     * @ORM\JoinColumn(nullable=true)
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=Livraison::class, inversedBy="livraisonDetails")
     * @ORM\JoinColumn(nullable=true)
     */
    private $livraison;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDetQuantiteLivree(): ?int
    {
        return $this->detQuantiteLivree;
    }

    public function setDetQuantiteLivree(int $detQuantiteLivree): self
    {
        $this->detQuantiteLivree = $detQuantiteLivree;

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

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }
}
