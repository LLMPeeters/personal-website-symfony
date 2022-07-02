<?php

namespace App\Entity;

use App\Repository\AbstractPageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class AbstractPage
{
    #[ORM\OneToOne(targetEntity: Hotlink::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $hotlink;

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
