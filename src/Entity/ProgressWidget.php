<?php

namespace App\Entity;

use App\Entity\AbstractWidget;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProgressWidgetRepository;

#[ORM\Entity(repositoryClass: ProgressWidgetRepository::class)]
class ProgressWidget extends AbstractWidget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'widget', targetEntity: ProgressWidgetData::class, orphanRemoval: true)]
    private $data;

    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ProgressWidgetData>
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function addData(ProgressWidgetData $data): self
    {
        if (!$this->data->contains($data)) {
            $this->data[] = $data;
            $data->setWidget($this);
        }

        return $this;
    }

    public function removeData(ProgressWidgetData $data): self
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
