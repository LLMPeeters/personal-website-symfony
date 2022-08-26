<?php

namespace App\Entity;

use App\Entity\Image;
use App\Entity\AbstractWidget;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectWidgetRepository;

#[ORM\Entity(repositoryClass: ProjectWidgetRepository::class)]
class ProjectWidget extends AbstractWidget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist', 'remove'])]
    private $image;

    #[ORM\Column(type: 'string', length: 500)]
    private $summary;

    #[ORM\OneToOne(mappedBy: 'widget', targetEntity: Project::class, cascade: ['persist', 'remove'])]
    private $project;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        // set the owning side of the relation if necessary
        if ($project->getWidget() !== $this) {
            $project->setWidget($this);
        }

        $this->project = $project;

        return $this;
    }
}
