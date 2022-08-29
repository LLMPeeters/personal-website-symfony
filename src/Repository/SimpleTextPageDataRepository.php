<?php

namespace App\Repository;

use App\Entity\SimpleTextPageData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SimpleTextPageData>
 *
 * @method SimpleTextPageData|null find($id, $lockMode = null, $lockVersion = null)
 * @method SimpleTextPageData|null findOneBy(array $criteria, array $orderBy = null)
 * @method SimpleTextPageData[]    findAll()
 * @method SimpleTextPageData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SimpleTextPageDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SimpleTextPageData::class);
    }

    public function add(SimpleTextPageData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SimpleTextPageData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SimpleTextPageData[] Returns an array of SimpleTextPageData objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SimpleTextPageData
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
