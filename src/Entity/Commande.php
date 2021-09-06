<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
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
    private $comNumero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comFiche;

    /**
     * @ORM\Column(type="string", length=255)
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
     * @ORM\Column(type="datetime")
     */
    private $comLivraison;

    /**
     * @ORM\Column(type="datetime")
     */
    private $comButoir;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="commande")
     */
    private $clients;

    /**
     * @ORM\ManyToOne(targetEntity=CommandeDetail::class, inversedBy="commande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commandeDetail;

    /**
     * @ORM\ManyToOne(targetEntity=Livraison::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $livraison;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComNumero(): ?int
    {
        return $this->comNumero;
    }

    public function setComNumero(int $comNumero): self
    {
        $this->comNumero = $comNumero;

        return $this;
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

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setCommande($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getCommande() === $this) {
                $client->setCommande(null);
            }
        }

        return $this;
    }

    public function getCommandeDetail(): ?CommandeDetail
    {
        return $this->commandeDetail;
    }

    public function setCommandeDetail(?CommandeDetail $commandeDetail): self
    {
        $this->commandeDetail = $commandeDetail;

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
