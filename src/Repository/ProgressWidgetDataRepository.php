<?php

namespace App\Repository;

use App\Entity\ProgressWidgetData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProgressWidgetData>
 *
 * @method ProgressWidgetData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgressWidgetData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgressWidgetData[]    findAll()
 * @method ProgressWidgetData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgressWidgetDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgressWidgetData::class);
    }

    public function add(ProgressWidgetData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProgressWidgetData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ProgressWidgetData[] Returns an array of ProgressWidgetData objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProgressWidgetData
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
