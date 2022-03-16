<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin extends User
{
    #[ORM\Column(type: 'integer')]
    private $badge_number;

    public function getBadgeNumber(): ?int
    {
        return $this->badge_number;
    }

    public function setBadgeNumber(int $badge_number): self
    {
        $this->badge_number = $badge_number;

        return $this;
    }
}
