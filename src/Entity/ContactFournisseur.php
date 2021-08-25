<?php

namespace App\Entity;

use App\Repository\ContactFournisseurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactFournisseurRepository::class)
 */
class ContactFournisseur
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
    private $conNom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $conPrenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $conMail;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $conTel;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $conVille;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $conPostal;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $conPays;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $conFax;

    /**
     * @ORM\Column(type="datetime")
     */
    private $conDate;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fournisseur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConNom(): ?string
    {
        return $this->conNom;
    }

    public function setConNom(string $conNom): self
    {
        $this->conNom = $conNom;

        return $this;
    }

    public function getConPrenom(): ?string
    {
        return $this->conPrenom;
    }

    public function setConPrenom(string $conPrenom): self
    {
        $this->conPrenom = $conPrenom;

        return $this;
    }

    public function getConMail(): ?string
    {
        return $this->conMail;
    }

    public function setConMail(string $conMail): self
    {
        $this->conMail = $conMail;

        return $this;
    }

    public function getConTel(): ?string
    {
        return $this->conTel;
    }

    public function setConTel(string $conTel): self
    {
        $this->conTel = $conTel;

        return $this;
    }

    public function getConVille(): ?string
    {
        return $this->conVille;
    }

    public function setConVille(?string $conVille): self
    {
        $this->conVille = $conVille;

        return $this;
    }

    public function getConPostal(): ?string
    {
        return $this->conPostal;
    }

    public function setConPostal(?string $conPostal): self
    {
        $this->conPostal = $conPostal;

        return $this;
    }

    public function getConPays(): ?string
    {
        return $this->conPays;
    }

    public function setConPays(string $conPays): self
    {
        $this->conPays = $conPays;

        return $this;
    }

    public function getConFax(): ?string
    {
        return $this->conFax;
    }

    public function setConFax(?string $conFax): self
    {
        $this->conFax = $conFax;

        return $this;
    }

    public function getConDate(): ?\DateTimeInterface
    {
        return $this->conDate;
    }

    public function setConDate(\DateTimeInterface $conDate): self
    {
        $this->conDate = $conDate;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }
}
