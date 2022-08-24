<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'project', targetEntity: ComplexPage::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $page;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'boolean')]
    private $hasCode;

    #[ORM\OneToOne(inversedBy: 'project', targetEntity: ProjectWidget::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $widget;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPage(): ?ComplexPage
    {
        return $this->page;
    }

    public function setPage(ComplexPage $page): self
    {
        $this->page = $page;

        return $this;
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

    public function isHasCode(): ?bool
    {
        return $this->hasCode;
    }

    public function setHasCode(bool $hasCode): self
    {
        $this->hasCode = $hasCode;

        return $this;
    }

    public function getWidget(): ?ProjectWidget
    {
        return $this->widget;
    }

    public function setWidget(ProjectWidget $widget): self
    {
        $this->widget = $widget;

        return $this;
    }
}
