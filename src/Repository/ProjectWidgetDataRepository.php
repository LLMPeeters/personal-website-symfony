<?php

namespace App\Repository;

use App\Entity\ProjectWidgetData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectWidgetData>
 *
 * @method ProjectWidgetData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectWidgetData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectWidgetData[]    findAll()
 * @method ProjectWidgetData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectWidgetDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectWidgetData::class);
    }

    public function add(ProjectWidgetData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProjectWidgetData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ProjectWidgetData[] Returns an array of ProjectWidgetData objects
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

//    public function findOneBySomeField($value): ?ProjectWidgetData
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
