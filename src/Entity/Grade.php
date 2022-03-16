<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
#[UniqueConstraint(name: "unique_grade", columns: ["note", "person_id", "control_id"])]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $note;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'grades')]
    private $Person;

    #[ORM\ManyToOne(targetEntity: Control::class, inversedBy: 'grades')]
    private $Control;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getPerson(): ?User
    {
        return $this->Person;
    }

    public function setPerson(?User $Person): self
    {
        $this->Person = $Person;

        return $this;
    }

    public function getControl(): ?Control
    {
        return $this->Control;
    }

    public function setControl(?Control $Control): self
    {
        $this->Control = $Control;

        return $this;
    }
}
