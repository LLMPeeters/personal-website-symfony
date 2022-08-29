<?php

namespace App\Entity;

use App\Entity\AbstractPage;
use App\Entity\AbstractPageData;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplexPageDataRepository;

#[ORM\Entity(repositoryClass: ComplexPageDataRepository::class)]
class ComplexPageData extends AbstractPageData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'array', nullable: true)]
    private $elements = [];

    #[ORM\ManyToOne(targetEntity: ComplexPage::class, inversedBy: 'data')]
    #[ORM\JoinColumn(nullable: false)]
    private $page;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getElements(): ?array
    {
        return $this->elements;
    }

    public function setElements(?array $elements): self
    {
        $this->elements = $elements;

        return $this;
    }

    public function getPage(): AbstractPage
    {
        return $this->page;
    }

    public function setPage(?AbstractPage $page): self
    {
        $this->page = $page;

        return $this;
    }
}
