<?php

namespace App\Repository;

use App\Entity\AssignmentRule;
use App\Entity\Domain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
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

    /**
     * Undocumented function
     *
     * @param Domain $domain
     * @return AssignmentRule[]
     */
    public function findByDomain(Domain $domain): array
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT r
            FROM App\Entity\AssignmentRule r
            JOIN r.keywordGroup kg
            JOIN kg.domain d
            WHERE d.name = :domain
            "
        );
        $query->setParameter('domain', $domain->getName());
        return $query->getResult();
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
