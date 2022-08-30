<?php

namespace App\EventListener;

use App\Entity\Hotlink;
use App\Entity\SupportedLanguage;
use App\Component\Pages\PageTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use App\Component\Pages\PageDataTypeEnum;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SupportedLanguageListener
{
	// PROBLEM: When this is preUpdate, there will be a fatal error about allowed memory size exhausted
    public function postUpdate(SupportedLanguage $lang, LifecycleEventArgs $event): void
    {
		if($lang->isMain()) {
			$this->resetMainProperty($lang, $event->getObjectManager());
		}
    }
	
	// Only for changing the 'main' property
	// Never change the 'countryCode' property
    public function prePersist(SupportedLanguage $lang, LifecycleEventArgs $event): void
    {
		if($lang->isMain()) {
			$this->resetMainProperty($lang, $event->getObjectManager());
		}
    }
	
	// When a new language is added, give all existing pages a corresponding data entity
	public function postPersist(SupportedLanguage $lang, LifecycleEventArgs $event): void
	{
		$em = $event->getObjectManager();
		
		// Loop through each type of page
		foreach(PageTypeEnum::cases() as $pageType) {
			$dataName = $pageType->getDataType();
			$repo = $em->getRepository($pageType->value);
			$pages = $repo->findAll();
			
			// Loop through each page to add the data entity
			foreach($pages as $page) {
				($newHotlink = new Hotlink())
					->setRoute($lang->getCountryCode().'/'.$page->getIdentifier())
					->setPageNamespace($page::class);
				($newData = new $dataName())
					->setSupportedLanguage($lang)
					->setTitle($page->getIdentifier())
					->setHotlink($newHotlink)
					->setPage($page);
				
				$em->persist($newHotlink);
				$em->persist($newData);
			}
		}
		
		$em->flush();
	}
	
	public function postDelete(SupportedLanguage $lang, LifecycleEventArgs $event): void
	{
		
	}
	
	private function resetMainProperty(SupportedLanguage $lang, EntityManagerInterface $em): bool
	{
		try {
			$repo = $em->getRepository($lang::class);
			($qb = $repo->createQueryBuilder('entity'))
				->select('entity')
				->andWhere('entity.main = true');
			
			if(!is_null($lang->getId())) {
				$qb
					->andWhere('entity.id != :id')
					->setParameter('id', $lang->getId());
			}
			
			foreach($qb->getQuery()->getResult() as $oldMain) {
				$oldMain->setMain(false);
				
				$em->persist($oldMain);
			}
			
			$em->flush();
			
			return true;
		} catch(\Exception $e) {
			return false;
		}
	}
}
