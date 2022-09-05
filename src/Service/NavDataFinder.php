<?php

namespace App\Service;

use App\Entity\AbstractPage;
use App\Entity\SupportedLanguage;
use App\Component\Pages\PageTypeEnum;
use Doctrine\Persistence\ManagerRegistry;

class NavDataFinder
{
	public function __construct(
		private ManagerRegistry $doctrine
	) {}
	
	public function getNavData(SupportedLanguage $lang): array
	{
		$dataArray = [];
		
		foreach(PageTypeEnum::cases() as $type) {
			if(!is_subclass_of($type->value, AbstractPage::class)) {
				throw new \LogicException(PageTypeEnum::class.' is out of order.');
			}
			
			$repo = $this->doctrine->getRepository($type->getDataType());
			$qb = $repo->createQueryBuilder('entity')
				->join('entity.page', 'page')
				->select('entity')
				->andWhere('entity.supportedLanguage = :lang')
				->setParameter('lang', $lang)
				->andWhere('page.addToNav = true');
			
			foreach($qb->getQuery()->getResult() as $data) {
				$dataArray[] = $data;
			}
		}
		
		return $dataArray;
	}
}
