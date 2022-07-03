<?php

namespace App\Entity;

use App\Repository\HotlinkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HotlinkRepository::class)]
class Hotlink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\Regex(
        pattern: '/^[a-zA-Z_]+$/',
        match: true,
        message: 'A hotlink route can only contain letters and underscores.',
    )]
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $route;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }
}
