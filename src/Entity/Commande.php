<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
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
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="client")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
