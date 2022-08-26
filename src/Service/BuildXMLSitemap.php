<?php

namespace App\Service;

use LogicException;
use App\Entity\AbstractPage;
use App\Component\Pages\PageTypeEnum;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\SerializerInterface;

class BuildXMLSitemap
{
	public function __construct(
		private ManagerRegistry $doctrine,
		private SerializerInterface $serializer,
		private RequestStack $requestStack
	) {}
	
	public function build(): array
	{
		$pages = [];
		$hostname = $this->requestStack->getCurrentRequest()->getSchemeAndHttpHost();
		
		foreach(PageTypeEnum::cases() as $type) {
			if(!is_subclass_of($type->value, AbstractPage::class)) {
				throw new LogicException(PageTypeEnum::class.' is out of order.');
			}
			
			$repo = $this->doctrine->getRepository($type->value);
			
			foreach($repo->findAll() as $page) {
				$pages[] = [
					'loc' => $hostname.'/'.$page->getHotlink()->getRoute(),
				];
			}
		}
		
		ksort($pages);
		
		return $pages;
	}
}
