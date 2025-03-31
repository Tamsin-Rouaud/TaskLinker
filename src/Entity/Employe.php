<?php

namespace App\Entity;

use App\Enum\EmployeStatus;
use App\Repository\EmployeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?EmployeStatus $status = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_entree = null;

     public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->date_entree;
    }

    public function setDateEntree(\DateTimeInterface $date_entree): static
    {
        $this->date_entree = $date_entree;

        return $this;
    }

    public function getStatus(): ?EmployeStatus
    {
        return $this->status;
    }

    public function setStatus(EmployeStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getInitiales(): string
    {
        $initialePrenom = $this->prenom ? strtoupper($this->prenom[0]) : '';
        $initialeNom = $this->nom ? strtoupper($this->nom[0]) : '';

        return $initialePrenom . $initialeNom;
    }
}
