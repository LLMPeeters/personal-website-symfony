<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CheckEntityProperty
{
	public function __construct(
		private EntityManagerInterface $em
	) {}
	
    public function doesEntityHaveUniquePropertyValue(string $propertyName, object $entity, mixed $checkValue = null): ?bool
	{
		$repo = $this->em->getRepository($entity::class);
		$checks = [
			'get'.ucfirst($propertyName),
			'is'.ucfirst($propertyName),
			'has'.ucfirst($propertyName)
		];
		$confirmed = false;
		
		if(is_null($checkValue)) {
			foreach($checks as $check) {
				if(method_exists($entity, $check)) {
					$checkValue = $entity->$check();
					$confirmed = true;
					
					break;
				}
			}
		} else {
			foreach($checks as $check) {
				if(method_exists($entity, $check) && $entity->$check() === $checkValue) {
					$confirmed = true;
					
					break;
				}
			}
		}
		
		if(
			!$repo instanceof ServiceEntityRepository
			|| !property_exists($entity, $propertyName)
			|| $confirmed === false
		) {
			return null;
		}
		
		$qb = $repo->createQueryBuilder('entity')
			->select('entity.id')
			->andWhere(':propertyName = :checkValue')
			->setParameter('propertyName', 'entity.'.$propertyName)
			->setParameter('checkValue', $checkValue);
		
		if($entity?->getId()) {
			$qb
				->andWhere('entity.id != :entityId')
				->setParameter('entityId', $entity->getId());
		}
		
		$result = $qb->getQuery()->getResult();
		
		return is_array($result) && count($result) === 0;
	}
}
