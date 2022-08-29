<?php

namespace App\EventListener;

use App\Entity\SupportedLanguage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SupportedLanguageListener
{
    public function preUpdate(SupportedLanguage $lang, LifecycleEventArgs $event): void
    {
		$this->isMainPropertyHandler($lang, $event->getObjectManager());
    }
	
    public function prePersist(SupportedLanguage $lang, LifecycleEventArgs $event): void
    {
		$this->isMainPropertyHandler($lang, $event->getObjectManager());
    }
	
	private function isMainPropertyHandler(SupportedLanguage $lang, EntityManagerInterface $em): bool
	{
		try {
			if($lang->isMain()) {
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
					if($lang !== $oldMain) {
						$oldMain->setMain(false);
						
						$em->persist($oldMain);
					}
				}
			}
			
			return true;
		} catch(\Exception $e) {
			return false;
		}
	}
}
