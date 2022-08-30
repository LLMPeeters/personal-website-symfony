<?php

namespace App\EventListener;

class PageListener
{
	public function postPersist(AbstractPage $page, LifecycleEventArgs $event): void
	{
		dd($page);
	}
}
