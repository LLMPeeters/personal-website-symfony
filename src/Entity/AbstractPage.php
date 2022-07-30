<?php

namespace App\Entity;

use App\Repository\AbstractPageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
abstract class AbstractPage
{
    #[Assert\Valid]
    #[Assert\Type(Hotlink::class)]
    #[ORM\OneToOne(targetEntity: Hotlink::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $hotlink;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    public function getHotlink(): ?Hotlink
    {
        return $this->hotlink;
    }

    public function setHotlink(Hotlink $hotlink): self
    {
        $this->hotlink = $hotlink;

        return $this;
    }
    
    public function getRoute(): string
    {
        return $this->hotlink->getRoute();
    }
    
    public function setRoute(string $route): self
    {
        $this->hotlink->setRoute($route);
        
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
}
