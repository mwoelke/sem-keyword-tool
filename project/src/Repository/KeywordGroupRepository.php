<?php

namespace App\Repository;

use App\Entity\KeywordGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KeywordGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method KeywordGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method KeywordGroup[]    findAll()
 * @method KeywordGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeywordGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KeywordGroup::class);
    }

    // /**
    //  * @return KeywordGroup[] Returns an array of KeywordGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KeywordGroup
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
