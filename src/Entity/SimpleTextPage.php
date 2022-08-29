<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\SimpleTextPageRepository;

#[ORM\Entity(repositoryClass: SimpleTextPageRepository::class)]
class SimpleTextPage extends AbstractPage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: SimpleTextPageData::class, orphanRemoval: true)]
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
     * @return Collection<int, ComplexPageData>
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function addData(SimpleTextPageData $data): self
    {
        if (!$this->data->contains($data)) {
            $this->data[] = $data;
            $data->setPage($this);
        }

        return $this;
    }

    public function removeData(SimpleTextPageData $data): self
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
