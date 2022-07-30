<?php

namespace App\Entity;

use App\Entity\AbstractWidget;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProgressWidgetRepository;

#[ORM\Entity(repositoryClass: ProgressWidgetRepository::class)]
class ProgressWidget extends AbstractWidget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'array')]
    private $progressBars = [];

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
}
