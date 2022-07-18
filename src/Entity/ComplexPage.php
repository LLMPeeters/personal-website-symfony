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

    #[ORM\Column(type: 'object')]
    private $elements;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getElements(): ?object
    {
        return $this->elements;
    }

    public function setElements(object $elements): self
    {
        $this->elements = $elements;

        return $this;
    }
}
