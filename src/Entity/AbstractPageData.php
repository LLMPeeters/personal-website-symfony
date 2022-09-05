<?php

namespace App\Entity;

use App\Entity\AbstractPage;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\SupportedLanguage;
use App\Repository\AbstractPageDataRepository;

#[ORM\MappedSuperclass]
abstract class AbstractPageData
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $title;

    #[ORM\ManyToOne(targetEntity: SupportedLanguage::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $supportedLanguage;

	#[Assert\Valid]
	#[Assert\Type(Hotlink::class)]
	#[ORM\OneToOne(targetEntity: Hotlink::class, cascade: ['persist', 'remove'])]
	#[ORM\JoinColumn(nullable: false)]
	private $hotlink;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $navName;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private $metaDescription;

	abstract public function getId(): ?int;
	abstract public function getPage(): AbstractPage;
	
	public function getRoute(): string
	{
		return $this->getSupportedLanguage()->getCountryCode().'/'.$this->getHotlink()->getRoute();
	}
	
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSupportedLanguage(): ?SupportedLanguage
    {
        return $this->supportedLanguage;
    }

    public function setSupportedLanguage(?SupportedLanguage $supportedLanguage): self
    {
        $this->supportedLanguage = $supportedLanguage;

        return $this;
    }

    public function getHotlink(): ?Hotlink
    {
        return $this->hotlink;
    }

    public function setHotlink(Hotlink $hotlink): self
    {
        $this->hotlink = $hotlink;

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

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }
}
