<?php

namespace App\Entity;

use App\Entity\AbstractPage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplexPageRepository;

#[ORM\Entity(repositoryClass: ComplexPageRepository::class)]
class ComplexPage extends AbstractPage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(mappedBy: 'page', targetEntity: Project::class, cascade: ['persist', 'remove'])]
    private $project;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: ComplexPageData::class, orphanRemoval: true)]
    private $data;

    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, ComplexPageData>
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function addData(ComplexPageData $data): self
    {
        if (!$this->data->contains($data)) {
            $this->data[] = $data;
            $data->setPage($this);
        }

        return $this;
    }

    public function removeData(ComplexPageData $data): self
    {
        if ($this->data->removeElement($data)) {
            // set the owning side to null (unless already changed)
            if ($data->getPage() === $this) {
                $data->setPage(null);
            }
        }

        return $this;
    }
}
