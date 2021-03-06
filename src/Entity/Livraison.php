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
     * @ORM\OneToMany(targetEntity=LivraisonDetail::class, mappedBy="livraison")
     */
    private $livraisonDetails;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="livraisons")
     * @ORM\JoinColumn(nullable=true)
     */
    private $commande;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $livDate;

    public function __construct()
    {
        $this->livraisonDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $livraisonDetail->setLivraison($this);
        }

        return $this;
    }

    public function removeLivraisonDetail(LivraisonDetail $livraisonDetail): self
    {
        if ($this->livraisonDetails->removeElement($livraisonDetail)) {
            // set the owning side to null (unless already changed)
            if ($livraisonDetail->getLivraison() === $this) {
                $livraisonDetail->setLivraison(null);
            }
        }

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

    public function getLivDate(): ?\DateTimeInterface
    {
        return $this->livDate;
    }

    public function setLivDate(\DateTimeInterface $livDate): self
    {
        $this->livDate = $livDate;

        return $this;
    }
}
