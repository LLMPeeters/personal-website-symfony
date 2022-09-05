<?php

namespace App\Service;

use LogicException;
use App\Entity\AbstractPage;
use App\Entity\SupportedLanguage;
use App\Component\Pages\PageTypeEnum;
use Doctrine\Persistence\ManagerRegistry;

class PagesToSitemap
{
	public function __construct(
		private ManagerRegistry $doctrine
	) {}
	
	public function getSitemapArray(SupportedLanguage $lang): array
	{
		$dataArray = [];
		
		foreach(PageTypeEnum::cases() as $type) {
			if(!is_subclass_of($type->value, AbstractPage::class)) {
				throw new LogicException(PageTypeEnum::class.' is out of order.');
			}
			
			$repo = $this->doctrine->getRepository($type->getDataType());
			
			foreach($repo->findBy(['supportedLanguage' => $lang]) as $data) {
				$dataArray[$data->getRoute()] = $data->getTitle();
			}
		}
		
		ksort($dataArray);
		
		return $dataArray;
	}
}
