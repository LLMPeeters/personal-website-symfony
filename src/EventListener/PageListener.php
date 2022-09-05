<?php

namespace App\EventListener;

use App\Entity\AbstractPage;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PageListener
{
	public function postPersist(AbstractPage $page, LifecycleEventArgs $event): void
	{
		
	}
}
