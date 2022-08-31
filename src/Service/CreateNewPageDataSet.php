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
					->setPageNamespace($page::class);
				
				($newData = new $dataName())
					->setSupportedLanguage($lang)
					->setHotlink($newHotlink)
					->setPage($page);
					
				$newHotlink
					->setPageData($newData)
					->setRoute($lang->getCountryCode().'/'.$page->getIdentifier());
				
				$page->addData($newData);
				
				// $this->em->persist($newHotlink);
				// $this->em->persist($newData);
			}
			
			// $this->em->persist($page);
			
			// $this->em->flush();
			
			return true;
		} catch(\Exception $e) {
			dump($e->getMessage());
			return false;
		}
	}
}
