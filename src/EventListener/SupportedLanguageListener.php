<?php

namespace App\EventListener;

use App\Entity\SupportedLanguage;
use Doctrine\ORM\EntityManagerInterface;
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
	
    public function prePersist(SupportedLanguage $lang, LifecycleEventArgs $event): void
    {
		if($lang->isMain()) {
			$this->resetMainProperty($lang, $event->getObjectManager());
		}
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
