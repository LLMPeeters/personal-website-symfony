<?php

namespace App\Entity;

use App\Entity\AbstractPage;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\SupportedLanguage;
use App\Repository\AbstractPageDataRepository;

#[ORM\MappedSuperclass]
abstract class AbstractPageData
{
    #[ORM\Column(type: 'string', length: 255)]
    private $identifier;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\ManyToOne(targetEntity: SupportedLanguage::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $supportedLanguage;

    #[ORM\OneToOne(inversedBy: 'pageData', targetEntity: Hotlink::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $hotlink;

	abstract public function getId(): ?int;
	abstract public function getPage(): AbstractPage;
	
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
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
}
