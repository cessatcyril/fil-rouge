<?php

namespace App\Entity;

use App\Entity\Client;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    const EN_COURS = 0;
    const PARTIELLEMENT_LIVREE = 1;
    const LIVREE = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comFiche;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comFacture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $comStatut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $comCommande;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $comLivraison;

    /**
     * @ORM\Column(type="datetime")
     */
    private $comButoir;

    /**
     * @ORM\OneToMany(targetEntity=CommandeDetail::class, mappedBy="commande")
     */
    private $commandeDetails;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commande")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=Livraison::class, mappedBy="commande")
     */
    private $livraisons;

    /**
     * @ORM\Column(type="boolean")
     */
    private $comPaiement = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $comAnnulation = false;

    public function __construct()
    {
        $this->commandeDetails = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComFiche(): ?string
    {
        return $this->comFiche;
    }

    public function setComFiche(string $comFiche): self
    {
        $this->comFiche = $comFiche;

        return $this;
    }

    public function getComFacture(): ?string
    {
        return $this->comFacture;
    }

    public function setComFacture(string $comFacture): self
    {
        $this->comFacture = $comFacture;

        return $this;
    }

    public function getComStatut(): ?bool
    {
        return $this->comStatut;
    }

    public function setComStatut(bool $comStatut): self
    {
        $this->comStatut = $comStatut;

        return $this;
    }

    public function getComCommande(): ?\DateTimeInterface
    {
        return $this->comCommande;
    }

    public function setComCommande(\DateTimeInterface $comCommande): self
    {
        $this->comCommande = $comCommande;

        return $this;
    }

    public function getComLivraison(): ?\DateTimeInterface
    {
        return $this->comLivraison;
    }

    public function setComLivraison(\DateTimeInterface $comLivraison): self
    {
        $this->comLivraison = $comLivraison;

        return $this;
    }

    public function getComButoir(): ?\DateTimeInterface
    {
        return $this->comButoir;
    }

    public function setComButoir(\DateTimeInterface $comButoir): self
    {
        $this->comButoir = $comButoir;

        return $this;
    }

    // /**
    //  * @return Collection|Client[]
    //  */
    // public function getClients(): Collection
    // {
    //     return $this->clients;
    // }

    // public function addClient(Client $client): self
    // {
    //     if (!$this->clients->contains($client)) {
    //         $this->clients[] = $client;
    //         $client->setCommande($this);
    //     }

    //     return $this;
    // }

    // public function removeClient(Client $client): self
    // {
    //     if ($this->clients->removeElement($client)) {
    //         // set the owning side to null (unless already changed)
    //         if ($client->getCommande() === $this) {
    //             $client->setCommande(null);
    //         }
    //     }

    //     return $this;
    // }

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
            $commandeDetail->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeDetail(CommandeDetail $commandeDetail): self
    {
        if ($this->commandeDetails->removeElement($commandeDetail)) {
            // set the owning side to null (unless already changed)
            if ($commandeDetail->getCommande() === $this) {
                $commandeDetail->setCommande(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|Livraison[]
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setCommande($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getCommande() === $this) {
                $livraison->setCommande(null);
            }
        }

        return $this;
    }

    public function getComPaiement(): ?bool
    {
        return $this->comPaiement;
    }

    public function setComPaiement(bool $comPaiement): self
    {
        $this->comPaiement = $comPaiement;

        return $this;
    }

    public function getComAnnulation(): ?bool
    {
        return $this->comAnnulation;
    }

    public function setComAnnulation(bool $comAnnulation): self
    {
        $this->comAnnulation = $comAnnulation;

        return $this;
    }
}
