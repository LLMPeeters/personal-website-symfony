<?php

namespace App\Entity;

use App\Repository\SupportedLanguageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupportedLanguageRepository::class)]
class SupportedLanguage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 2)]
    private $countryCode;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $main;

	public function __toString(): string
	{
		return $this->getCountryCode();
	}
	
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function isMain(): ?bool
    {
        return $this->main;
    }

    public function setMain(?bool $main): self
    {
        $this->main = $main;

        return $this;
    }
}
