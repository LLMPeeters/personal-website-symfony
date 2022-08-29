<?php

namespace App\Entity;

use App\Repository\ProjectWidgetDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectWidgetDataRepository::class)]
class ProjectWidgetData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 1000, nullable: true)]
    private $summary;

    #[ORM\ManyToOne(targetEntity: ProjectWidget::class, inversedBy: 'data')]
    #[ORM\JoinColumn(nullable: false)]
    private $widget;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getWidget(): ?ProjectWidget
    {
        return $this->widget;
    }

    public function setWidget(?ProjectWidget $widget): self
    {
        $this->widget = $widget;

        return $this;
    }
}
