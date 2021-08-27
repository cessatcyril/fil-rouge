<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeRepository::class)
 */
class Employe
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
    private $empNom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $empPrenom;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $empTel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmpNom(): ?string
    {
        return $this->empNom;
    }

    public function setEmpNom(string $empNom): self
    {
        $this->empNom = $empNom;

        return $this;
    }

    public function getEmpPrenom(): ?string
    {
        return $this->empPrenom;
    }

    public function setEmpPrenom(string $empPrenom): self
    {
        $this->empPrenom = $empPrenom;

        return $this;
    }

    public function getEmpTel(): ?string
    {
        return $this->empTel;
    }

    public function setEmpTel(string $empTel): self
    {
        $this->empTel = $empTel;

        return $this;
    }
}
