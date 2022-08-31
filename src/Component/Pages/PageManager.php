<?php

namespace App\Component\Pages;

use App\Entity\Hotlink;
use App\Entity\SupportedLanguage;
use App\Component\Pages\PageTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use App\Component\SupportedLanguages\SupportedLanguageHelperInterface;

class PageManager implements SupportedLanguageHelperInterface
{
	public function __construct(
		private EntityManagerInterface $em
	) {}
	
	public function deleteDataRelatedToLang(SupportedLanguage $lang): bool
	{
		try {
			// Loop through each type of page data
			foreach(PageTypeEnum::cases() as $pageType) {
				$dataName = $pageType->getDataType();
				$repo = $this->em->getRepository($dataName);
				$pageData = $repo->findBy(['supportedLanguage' => $lang]);
				
				// Loop through each data to delete it
				foreach($pageData as $data) {
					$this->em->remove($data->getHotlink());
					$this->em->remove($data);
				}
			}
			
			return true;
		} catch(\Exception $e) {
			return false;
		}
	}
	
	public function fillDataForNewLang(SupportedLanguage $lang): bool
	{
		try {
			// Loop through each type of page
			foreach(PageTypeEnum::cases() as $pageType) {
				$dataName = $pageType->getDataType();
				$repo = $this->em->getRepository($pageType->value);
				$pages = $repo->findAll();
				
				// Loop through each page to add the data entity
				foreach($pages as $page) {
					($newHotlink = new Hotlink())
						->setRoute(strval($page->getIdentifier()))
						->setPageDataNamespace($dataName)
						->setPageNamespace($page::class);
					($newData = new $dataName())
						->setSupportedLanguage($lang)
						->setTitle($page->getIdentifier())
						->setHotlink($newHotlink)
						->setPage($page);
					
					$this->em->persist($newHotlink);
					$this->em->persist($newData);
				}
			}
			
			$this->em->flush();
			
			return true;
		} catch(\Exception $e) {
			return false;
		}
	}
}