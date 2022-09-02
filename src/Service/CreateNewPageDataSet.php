<?php

namespace App\Service;

use App\Entity\Hotlink;
use App\Entity\AbstractPage;
use App\Component\Pages\PageTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SupportedLanguageRepository;

class CreateNewPageDataSet
{
	public function __construct(
		private SupportedLanguageRepository $slRepo,
		private EntityManagerInterface $em
	) {}
	
	public function create(AbstractPage $page): bool
	{
		try {
			foreach($this->slRepo->findAll() as $lang) {
				$pageType = PageTypeEnum::tryFrom($page::class);
				
				if(!$pageType instanceof PageTypeEnum) {
					return false;
				}
				
				$dataName = $pageType->getDataType();
				
				($newHotlink = new Hotlink())
					->setPageDataNamespace($pageType->getDataType())
					->setPageNamespace($page::class);
				
				($newData = new $dataName())
					->setSupportedLanguage($lang)
					->setHotlink($newHotlink)
					->setPage($page);
					
				$newHotlink
					->setRoute(strval($page->getIdentifier()));
				
				$page->addData($newData);
			}
			
			return true;
		} catch(\Exception $e) {
			dump($e->getMessage());
			
			return false;
		}
	}
}
