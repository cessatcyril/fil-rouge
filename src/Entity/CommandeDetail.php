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
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="commandeDetail")
     */
    private $commande;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="commandeDetail")
     */
    private $produit;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    private $detRemise;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    private $detPrixVente;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
        $this->produit = new ArrayCollection();
    }

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

    /**
     * @return Collection|Commande[]
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande[] = $commande;
            $commande->setCommandeDetail($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getCommandeDetail() === $this) {
                $commande->setCommandeDetail(null);
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
            $produit->setCommandeDetail($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCommandeDetail() === $this) {
                $produit->setCommandeDetail(null);
            }
        }

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
}
