<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractWidgetData;
use Doctrine\Common\Collections\Collection;

#[ORM\MappedSuperclass]
abstract class AbstractWidget
{
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $identifier;

    abstract public function getId(): ?int;
	abstract public function getData(): Collection;
    
    public function getIdentifier(): string
    {
        return $this->identifier;
    }
    
    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }
}
