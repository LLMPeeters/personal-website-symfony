<?php

namespace App\Repository;

use App\Entity\AbstractWidgetData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AbstractWidgetData>
 *
 * @method AbstractWidgetData|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractWidgetData|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractWidgetData[]    findAll()
 * @method AbstractWidgetData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractWidgetDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractWidgetData::class);
    }

    public function add(AbstractWidgetData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AbstractWidgetData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AbstractWidgetData[] Returns an array of AbstractWidgetData objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AbstractWidgetData
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
