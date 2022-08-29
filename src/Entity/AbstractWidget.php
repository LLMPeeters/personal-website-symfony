<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class AbstractWidget
{
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $identifier;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    abstract public function getId(): ?int;
    
    public function getIdentifier(): string
    {
        return $this->identifier;
    }
    
    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
