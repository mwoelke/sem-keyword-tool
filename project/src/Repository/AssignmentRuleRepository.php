<?php

namespace App\Repository;

use App\Entity\AssignmentRule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AssignmentRule|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssignmentRule|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssignmentRule[]    findAll()
 * @method AssignmentRule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssignmentRuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssignmentRule::class);
    }

    // /**
    //  * @return AssignmentRule[] Returns an array of AssignmentRule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AssignmentRule
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
