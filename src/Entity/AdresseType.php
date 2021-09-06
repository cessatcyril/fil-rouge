<?php

namespace App\Entity;

use App\Repository\AdresseTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="adresseType")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=Adresse::class, mappedBy="adresseType")
     */
    private $adresse;

    public function __construct()
    {
        $this->client = new ArrayCollection();
        $this->adresse = new ArrayCollection();
    }

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

    /**
     * @return Collection|Client[]
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Client $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->setAdresseType($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getAdresseType() === $this) {
                $client->setAdresseType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Adresse[]
     */
    public function getAdresse(): Collection
    {
        return $this->adresse;
    }

    public function addAdresse(Adresse $adresse): self
    {
        if (!$this->adresse->contains($adresse)) {
            $this->adresse[] = $adresse;
            $adresse->setAdresseType($this);
        }

        return $this;
    }

    public function removeAdresse(Adresse $adresse): self
    {
        if ($this->adresse->removeElement($adresse)) {
            // set the owning side to null (unless already changed)
            if ($adresse->getAdresseType() === $this) {
                $adresse->setAdresseType(null);
            }
        }

        return $this;
    }
}
