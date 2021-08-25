<?php

namespace App\Entity;

use App\Repository\AdresseTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdresseTypeRepository::class)
 */
class AdresseType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $typAdresse;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity=Adresse::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypAdresse(): ?int
    {
        return $this->typAdresse;
    }

    public function setTypAdresse(int $typAdresse): self
    {
        $this->typAdresse = $typAdresse;

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

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}
