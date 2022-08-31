<?php

namespace App\EventListener;

use App\Entity\Hotlink;
use App\Entity\SupportedLanguage;
use App\Component\Pages\PageManager;
use App\Component\Pages\PageTypeEnum;
use App\Component\Widgets\WidgetManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Component\Pages\PageDataTypeEnum;
use Doctrine\Persistence\Event\LifecycleEventArgs;

// TODO: Removing all of a language's related data should be done in a service that should be put into the proper Enum or Manager as well
class SupportedLanguageListener
{
	public function __construct(
		private PageManager $pManager,
		private WidgetManager $wManager
	) {}
	
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
	
	public function postPersist(SupportedLanguage $lang, LifecycleEventArgs $event): void
	{
		$this->pManager->fillDataForNewLang($lang);
		$this->wManager->fillDataForNewLang($lang);
	}
	
	public function preRemove(SupportedLanguage $lang, LifecycleEventArgs $event): void
	{
		$this->pManager->deleteDataRelatedToLang($lang);
		$this->wManager->deleteDataRelatedToLang($lang);
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
