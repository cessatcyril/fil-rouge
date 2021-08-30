<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    private $catNom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $catImage;

    public function __construct()
    {
        $this->SousCategorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatNom(): ?string
    {
        return $this->catNom;
    }

    public function setCatNom(string $catNom): self
    {
        $this->catNom = $catNom;

        return $this;
    }

    public function getCatImage(): ?string
    {
        return $this->catImage;
    }

    public function setCatImage(string $catImage): self
    {
        $this->catImage = $catImage;

        return $this;
    }
}
