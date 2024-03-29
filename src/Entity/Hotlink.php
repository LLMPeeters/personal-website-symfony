<?php

namespace App\Entity;

use App\Entity\AbstractPageData;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HotlinkRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HotlinkRepository::class)]
class Hotlink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\Regex(
        pattern: '/^[a-zA-Z_\/]+$/',
        match: true,
        message: 'A hotlink route can only contain letters and underscores.',
    )]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $route;

    #[ORM\Column(type: 'string', length: 255)]
    private $pageNamespace;

    #[ORM\Column(type: 'string', length: 500)]
    private $pageDataNamespace;

    #[ORM\ManyToOne(targetEntity: SupportedLanguage::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $supportedLanguage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        if(preg_match('/^\//', $route)) {
            $route = substr($route, 1);
        }
        
        $this->route = $route;

        return $this;
    }

    public function getPageNamespace(): ?string
    {
        return $this->pageNamespace;
    }

    public function setPageNamespace(string $pageNamespace): self
    {
        $this->pageNamespace = $pageNamespace;

        return $this;
    }

    public function getPageDataNamespace(): ?string
    {
        return $this->pageDataNamespace;
    }

    public function setPageDataNamespace(string $pageDataNamespace): self
    {
        $this->pageDataNamespace = $pageDataNamespace;

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
}
