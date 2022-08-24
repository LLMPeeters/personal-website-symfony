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

    #[ORM\OneToOne(mappedBy: 'page', targetEntity: Project::class, cascade: ['persist', 'remove'])]
    private $project;

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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        // set the owning side of the relation if necessary
        if ($project->getPage() !== $this) {
            $project->setPage($this);
        }

        $this->project = $project;

        return $this;
    }
}
