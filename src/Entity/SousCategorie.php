<?php

namespace App\Entity;

use App\Repository\SousCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SousCategorieRepository::class)
 */
class SousCategorie
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
    private $souNom;

    // /**
    //  * @ORM\ManyToOne(targetEntity=Categorie::class)
    //  * @ORM\JoinColumn(nullable=false)
    //  */
    // private $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $souImage;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="sousCategories")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="sousCategorie")
     */
    private $produits;

    public function __construct()
    {
        $this->Produit = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSouNom(): ?string
    {
        return $this->souNom;
    }

    public function setSouNom(string $souNom): self
    {
        $this->souNom = $souNom;

        return $this;
    }

    // public function getCategorie(): ?Categorie
    // {
    //     return $this->categorie;
    // }

    // public function setCategorie(?Categorie $categorie): self
    // {
    //     $this->categorie = $categorie;

    //     return $this;
    // }

    public function getSouImage(): ?string
    {
        return $this->souImage;
    }

    public function setSouImage(string $souImage): self
    {
        $this->souImage = $souImage;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setSousCategorie($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getSousCategorie() === $this) {
                $produit->setSousCategorie(null);
            }
        }

        return $this;
    }
}
