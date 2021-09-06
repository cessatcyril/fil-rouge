<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivraisonRepository::class)
 */
class Livraison
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
    private $livQuantite;

    /**
     * @ORM\ManyToOne(targetEntity=LivraisonDetail::class, inversedBy="livraison")
     * @ORM\JoinColumn(nullable=false)
     */
    private $livraisonDetail;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="livraison")
     */
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivQuantite(): ?\DateTimeInterface
    {
        return $this->quantiteLivree;
    }

    public function setLivQuantite(\DateTimeInterface $quantiteLivree): self
    {
        $this->quantiteLivree = $quantiteLivree;

        return $this;
    }

    public function getLivraisonDetail(): ?LivraisonDetail
    {
        return $this->livraisonDetail;
    }

    public function setLivraisonDetail(?LivraisonDetail $livraisonDetail): self
    {
        $this->livraisonDetail = $livraisonDetail;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }
}
