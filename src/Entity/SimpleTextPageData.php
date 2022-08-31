<?php

namespace App\Entity;

use App\Entity\AbstractPage;
use App\Entity\AbstractPageData;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SimpleTextPageDataRepository;

#[ORM\Entity(repositoryClass: SimpleTextPageDataRepository::class)]
class SimpleTextPageData extends AbstractPageData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text', nullable: true)]
    private $rawHtml;

    #[ORM\ManyToOne(targetEntity: SimpleTextPage::class, inversedBy: 'data')]
    #[ORM\JoinColumn(nullable: false)]
    private $page;

    #[ORM\Column(type: 'string', length: 255)]
    private $navName;

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

    public function getPage(): AbstractPage
    {
        return $this->page;
    }

    public function setPage(?AbstractPage $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getNavName(): ?string
    {
        return $this->navName;
    }

    public function setNavName(string $navName): self
    {
        $this->navName = $navName;

        return $this;
    }
}
