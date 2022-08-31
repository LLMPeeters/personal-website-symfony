<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AbstractPageRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
abstract class AbstractPage
{
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $identifier;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $addToNav;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $public;
	
	abstract public function getId(): ?int;
	abstract public function getData(): Collection;

    public function getRoute(): string
    {
        return $this->hotlink->getRoute();
    }
    
    public function setRoute(string $route): self
    {
        $this->hotlink->setRoute($route);
        
        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function isAddToNav(): ?bool
    {
        return $this->addToNav;
    }

    public function setAddToNav(?bool $addToNav): self
    {
        $this->addToNav = $addToNav;

        return $this;
    }

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(?bool $public): self
    {
        $this->public = $public;

        return $this;
    }
}
