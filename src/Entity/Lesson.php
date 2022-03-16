<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
#[UniqueConstraint(name: "unique_lesson", columns: ["name", "start_lesson", "end_lesson"])]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $start_lesson;

    #[ORM\Column(type: 'datetime')]
    private $end_lesson;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'promotion')]
    private $users;

    #[ORM\OneToMany(mappedBy: 'Lesson', targetEntity: Control::class)]
    private $controls;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->controls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartLesson(): ?\DateTimeInterface
    {
        return $this->start_lesson;
    }

    public function setStartLesson(\DateTimeInterface $start_lesson): self
    {
        $this->start_lesson = $start_lesson;

        return $this;
    }

    public function getEndLesson(): ?\DateTimeInterface
    {
        return $this->end_lesson;
    }

    public function setEndLesson(\DateTimeInterface $end_lesson): self
    {
        $this->end_lesson = $end_lesson;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addPromotion($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removePromotion($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Control>
     */
    public function getControls(): Collection
    {
        return $this->controls;
    }

    public function addControl(Control $control): self
    {
        if (!$this->controls->contains($control)) {
            $this->controls[] = $control;
            $control->setLesson($this);
        }

        return $this;
    }

    public function removeControl(Control $control): self
    {
        if ($this->controls->removeElement($control)) {
            // set the owning side to null (unless already changed)
            if ($control->getLesson() === $this) {
                $control->setLesson(null);
            }
        }

        return $this;
    }
}
