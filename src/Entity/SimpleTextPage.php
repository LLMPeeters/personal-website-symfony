<?php

namespace App\Entity;

use App\Repository\SimpleTextPageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SimpleTextPageRepository::class)]
class SimpleTextPage extends AbstractPage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $rawHtml;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRawHtml(): ?string
    {
        return $this->rawHtml;
    }

    public function setRawHtml(string $rawHtml): self
    {
        $this->rawHtml = $rawHtml;

        return $this;
    }
}
