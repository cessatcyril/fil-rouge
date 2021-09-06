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
     * @ORM\OneToMany(targetEntity=Livraison::class, mappedBy="livraisonDetail")
     */
    private $livraison;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="livraisonDetail")
     */
    private $produit;

    public function __construct()
    {
        $this->livraison = new ArrayCollection();
        $this->produit = new ArrayCollection();
    }

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

    /**
     * @return Collection|Livraison[]
     */
    public function getLivraison(): Collection
    {
        return $this->livraison;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraison->contains($livraison)) {
            $this->livraison[] = $livraison;
            $livraison->setLivraisonDetail($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraison->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivraisonDetail() === $this) {
                $livraison->setLivraisonDetail(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
            $produit->setLivraisonDetail($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getLivraisonDetail() === $this) {
                $produit->setLivraisonDetail(null);
            }
        }

        return $this;
    }
}
