<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalleRepository::class)]
class Salle
{
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $nbrH = null;

    #[ORM\ManyToOne(inversedBy: 'salles')]
    private ?Departement $Department = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getNbrH(): ?int
    {
        return $this->nbrH;
    }

    public function setNbrH(int $nbrH): static
    {
        $this->nbrH = $nbrH;

        return $this;
    }

    public function getDepartment(): ?Departement
    {
        return $this->Department;
    }

    public function setDepartment(?Departement $Department): static
    {
        $this->Department = $Department;

        return $this;
    }
}
