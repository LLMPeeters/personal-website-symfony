<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractWidgetData;
use App\Repository\ProgressWidgetDataRepository;

#[ORM\Entity(repositoryClass: ProgressWidgetDataRepository::class)]
class ProgressWidgetData extends AbstractWidgetData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'array')]
    private $progressBars = [];

    #[ORM\ManyToOne(targetEntity: ProgressWidget::class, inversedBy: 'data')]
    #[ORM\JoinColumn(nullable: false)]
    private $widget;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgressBars(): ?array
    {
        return $this->progressBars;
    }

    public function setProgressBars(array $progressBars): self
    {
        $this->progressBars = $progressBars;

        return $this;
    }

    public function getWidget(): ?ProgressWidget
    {
        return $this->widget;
    }

    public function setWidget(?ProgressWidget $widget): self
    {
        $this->widget = $widget;

        return $this;
    }
}
