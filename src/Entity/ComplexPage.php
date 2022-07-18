<?php

namespace App\Entity;

use App\Entity\AbstractPage;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplexPageRepository;

#[ORM\Entity(repositoryClass: ComplexPageRepository::class)]
class ComplexPage extends AbstractPage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'array')]
    private $elements;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getElements(): ?array
    {
        return $this->elements;
    }

    public function setElements(array $elements): self
    {
        $this->elements = $elements;

        return $this;
    }
}
