<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
    private $cliNom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $cliPrenom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $cliNaissance;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $cliTel;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $cliFax;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cliSexe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $cliDate;

    /**
     * @ORM\OneToMany(targetEntity=Entreprise::class, mappedBy="client")
     */
    private $entreprises;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Employe::class, mappedBy="client")
     */
    private $employe;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="clients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity=AdresseType::class, inversedBy="client")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresseType;


    public function __construct()
    {
        $this->Commande = new ArrayCollection();
        $this->entreprises = new ArrayCollection();
        $this->employe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCliNom(): ?string
    {
        return $this->cliNom;
    }

    public function setCliNom(string $cliNom): self
    {
        $this->cliNom = $cliNom;

        return $this;
    }

    public function getCliPrenom(): ?string
    {
        return $this->cliPrenom;
    }

    public function setCliPrenom(string $cliPrenom): self
    {
        $this->cliPrenom = $cliPrenom;

        return $this;
    }

    public function getCliNaissance(): ?\DateTimeInterface
    {
        return $this->cliNaissance;
    }

    public function setCliNaissance(?\DateTimeInterface $cliNaissance): self
    {
        $this->cliNaissance = $cliNaissance;

        return $this;
    }

    public function getCliTel(): ?string
    {
        return $this->cliTel;
    }

    public function setCliTel(?string $cliTel): self
    {
        $this->cliTel = $cliTel;

        return $this;
    }

    public function getCliFax(): ?string
    {
        return $this->cliFax;
    }

    public function setCliFax(?string $cliFax): self
    {
        $this->cliFax = $cliFax;

        return $this;
    }

    public function getCliSexe(): ?bool
    {
        return $this->cliSexe;
    }

    public function setCliSexe(?bool $cliSexe): self
    {
        $this->cliSexe = $cliSexe;

        return $this;
    }

    public function getCliDate(): ?\DateTimeInterface
    {
        return $this->cliDate;
    }

    public function setCliDate(\DateTimeInterface $cliDate): self
    {
        $this->cliDate = $cliDate;

        return $this;
    }

    /**
     * @return Collection|Entreprise[]
     */
    public function getEntreprises(): Collection
    {
        return $this->entreprises;
    }

    public function addEntreprise(Entreprise $entreprise): self
    {
        if (!$this->entreprises->contains($entreprise)) {
            $this->entreprises[] = $entreprise;
            $entreprise->setClient($this);
        }

        return $this;
    }

    public function removeEntreprise(Entreprise $entreprise): self
    {
        if ($this->entreprises->removeElement($entreprise)) {
            // set the owning side to null (unless already changed)
            if ($entreprise->getClient() === $this) {
                $entreprise->setClient(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Employe[]
     */
    public function getEmploye(): Collection
    {
        return $this->employe;
    }

    public function addEmploye(Employe $employe): self
    {
        if (!$this->employe->contains($employe)) {
            $this->employe[] = $employe;
            $employe->setClient($this);
        }

        return $this;
    }

    public function removeEmploye(Employe $employe): self
    {
        if ($this->employe->removeElement($employe)) {
            // set the owning side to null (unless already changed)
            if ($employe->getClient() === $this) {
                $employe->setClient(null);
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

    public function getAdresseType(): ?AdresseType
    {
        return $this->adresseType;
    }

    public function setAdresseType(?AdresseType $adresseType): self
    {
        $this->adresseType = $adresseType;

        return $this;
    }
}
