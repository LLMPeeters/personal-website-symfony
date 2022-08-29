<?php

namespace App\Entity;

use App\Entity\AbstractWidget;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AbstractWidgetDataRepository;

#[ORM\MappedSuperclass]
abstract class AbstractWidgetData
{
    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    abstract public function getId(): ?int;
	abstract public function getWidget(): ?AbstractWidget;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
