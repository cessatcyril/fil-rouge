<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imaNom;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="image")
     */
    private $produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImaNom(): ?string
    {
        return $this->imaNom;
    }

    public function setImaNom(string $imaNom): self
    {
        $this->imaNom = $imaNom;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function __toString()
    {
        return $this->ima_nom;
    }
}

