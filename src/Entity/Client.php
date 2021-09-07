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
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=AdresseType::class, mappedBy="client")
     */
    private $adresseTypes;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="client")
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $entreprise;

    /**
     * @ORM\ManyToOne(targetEntity=Employe::class, inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $employe;


    public function __construct()
    {
        $this->adresseTypes = new ArrayCollection();
        $this->commande = new ArrayCollection();
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
     * @return Collection|AdresseType[]
     */
    public function getAdresseTypes(): Collection
    {
        return $this->adresseTypes;
    }

    public function addAdresseType(AdresseType $adresseType): self
    {
        if (!$this->adresseTypes->contains($adresseType)) {
            $this->adresseTypes[] = $adresseType;
            $adresseType->setClient($this);
        }

        return $this;
    }

    public function removeAdresseType(AdresseType $adresseType): self
    {
        if ($this->adresseTypes->removeElement($adresseType)) {
            // set the owning side to null (unless already changed)
            if ($adresseType->getClient() === $this) {
                $adresseType->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): self
    {
        $this->employe = $employe;

        return $this;
    }
}
