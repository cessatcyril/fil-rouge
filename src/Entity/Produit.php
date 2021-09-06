<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
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
    private $proProduit;

    /**
     * @ORM\Column(type="text")
     */
    private $proDescription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $proAccroche;

    /**
     * @ORM\Column(type="integer")
     */
    private $proStockAc;

    /**
     * @ORM\Column(type="integer")
     */
    private $proStockAl;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $proPrixA;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $proPrixV;

    /**
     * @ORM\Column(type="integer")
     */
    private $proStockC;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="produit")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategorie::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sousCategorie;

    /**
     * @ORM\ManyToMany(targetEntity=Fournisseur::class, mappedBy="produit")
     */
    private $fournisseurs;

    /**
     * @ORM\OneToMany(targetEntity=LivraisonDetail::class, mappedBy="produit")
     */
    private $livraisonDetails;

    /**
     * @ORM\OneToMany(targetEntity=CommandeDetail::class, mappedBy="produit")
     */
    private $commandeDetails;

    public function __construct()
    {
        $this->image = new ArrayCollection();
        $this->fournisseurs = new ArrayCollection();
        $this->livraisonDetails = new ArrayCollection();
        $this->commandeDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProProduit(): ?string
    {
        return $this->proProduit;
    }

    public function setProProduit(string $proProduit): self
    {
        $this->proProduit = $proProduit;

        return $this;
    }

    public function getProDescription(): ?string
    {
        return $this->proDescription;
    }

    public function setProDescription(string $proDescription): self
    {
        $this->proDescription = $proDescription;

        return $this;
    }

    public function getProAccroche(): ?string
    {
        return $this->proAccroche;
    }

    public function setProAccroche(string $proAccroche): self
    {
        $this->proAccroche = $proAccroche;

        return $this;
    }

    public function getProStockAc(): ?int
    {
        return $this->proStockAc;
    }

    public function setProStockAc(int $proStockAc): self
    {
        $this->proStockAc = $proStockAc;

        return $this;
    }

    public function getProStockAl(): ?int
    {
        return $this->proStockAl;
    }

    public function setProStockAl(int $proStockAl): self
    {
        $this->proStockAl = $proStockAl;

        return $this;
    }

    public function getProPrixA(): ?string
    {
        return $this->proPrixA;
    }

    public function setProPrixA(string $proPrixA): self
    {
        $this->proPrixA = $proPrixA;

        return $this;
    }

    public function getProPrixV(): ?string
    {
        return $this->proPrixV;
    }

    public function setProPrixV(string $proPrixV): self
    {
        $this->proPrixV = $proPrixV;

        return $this;
    }

    public function getProStockC(): ?int
    {
        return $this->proStockC;
    }

    public function setProStockC(int $proStockC): self
    {
        $this->proStockC = $proStockC;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setProduit($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduit() === $this) {
                $image->setProduit(null);
            }
        }

        return $this;
    }

    public function getSousCategorie(): ?SousCategorie
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?SousCategorie $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }

    public function getImagePrincipale()
    {
        foreach ($this->image as $i) {
            return $i->getImaNom();
        }
        return "";
    }

    public function getImages()
    {
        $liste = null;

        foreach ($this->image as $key) {
            $liste[] = $key->getImaNom();
        }
        return $liste;
    }

    /**
     * @return Collection|Fournisseur[]
     */
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Fournisseur $fournisseur): self
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs[] = $fournisseur;
            $fournisseur->addProduit($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): self
    {
        if ($this->fournisseurs->removeElement($fournisseur)) {
            $fournisseur->removeProduit($this);
        }

        return $this;
    }

    /**
     * @return Collection|LivraisonDetail[]
     */
    public function getLivraisonDetails(): Collection
    {
        return $this->livraisonDetails;
    }

    public function addLivraisonDetail(LivraisonDetail $livraisonDetail): self
    {
        if (!$this->livraisonDetails->contains($livraisonDetail)) {
            $this->livraisonDetails[] = $livraisonDetail;
            $livraisonDetail->setProduit($this);
        }

        return $this;
    }

    public function removeLivraisonDetail(LivraisonDetail $livraisonDetail): self
    {
        if ($this->livraisonDetails->removeElement($livraisonDetail)) {
            // set the owning side to null (unless already changed)
            if ($livraisonDetail->getProduit() === $this) {
                $livraisonDetail->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommandeDetail[]
     */
    public function getCommandeDetails(): Collection
    {
        return $this->commandeDetails;
    }

    public function addCommandeDetail(CommandeDetail $commandeDetail): self
    {
        if (!$this->commandeDetails->contains($commandeDetail)) {
            $this->commandeDetails[] = $commandeDetail;
            $commandeDetail->setProduit($this);
        }

        return $this;
    }

    public function removeCommandeDetail(CommandeDetail $commandeDetail): self
    {
        if ($this->commandeDetails->removeElement($commandeDetail)) {
            // set the owning side to null (unless already changed)
            if ($commandeDetail->getProduit() === $this) {
                $commandeDetail->setProduit(null);
            }
        }

        return $this;
    }
}
