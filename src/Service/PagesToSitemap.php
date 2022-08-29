<?php

namespace App\Service;

use LogicException;
use App\Entity\AbstractPage;
use App\Component\Pages\PageTypeEnum;
use Doctrine\Persistence\ManagerRegistry;

class PagesToSitemap
{
	public function __construct(
		private ManagerRegistry $doctrine
	) {}
	
	public function getSitemapArray(): array
	{
		$pages = [];
		
		foreach(PageTypeEnum::cases() as $type) {
			if(!is_subclass_of($type->value, AbstractPage::class)) {
				throw new LogicException(PageTypeEnum::class.' is out of order.');
			}
			
			$repo = $this->doctrine->getRepository($type->value);
			
			foreach($repo->findAll() as $page) {
				$pages[$page->getHotlink()->getRoute()] = $page->getTitle();
			}
		}
		
		ksort($pages);
		
		return $pages;
	}
}
