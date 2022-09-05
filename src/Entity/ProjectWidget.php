<?php

namespace App\Entity;

use App\Entity\Image;
use App\Entity\AbstractWidget;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToOne(mappedBy: 'widget', targetEntity: Project::class, cascade: ['persist', 'remove'])]
    private $project;

    #[ORM\OneToMany(mappedBy: 'widget', targetEntity: ProjectWidgetData::class, orphanRemoval: true)]
    private $data;

    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, ProjectWidgetData>
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function addData(ProjectWidgetData $data): self
    {
        if (!$this->data->contains($data)) {
            $this->data[] = $data;
            $data->setWidget($this);
        }

        return $this;
    }

    public function removeData(ProjectWidgetData $data): self
    {
        if ($this->data->removeElement($data)) {
            // set the owning side to null (unless already changed)
            if ($data->getWidget() === $this) {
                $data->setWidget(null);
            }
        }

        return $this;
    }
}
