<?php

namespace App\Repository;

use App\Entity\KeywordGroupKeyword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KeywordGroupKeyword|null find($id, $lockMode = null, $lockVersion = null)
 * @method KeywordGroupKeyword|null findOneBy(array $criteria, array $orderBy = null)
 * @method KeywordGroupKeyword[]    findAll()
 * @method KeywordGroupKeyword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeywordGroupKeywordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KeywordGroupKeyword::class);
    }

    // /**
    //  * @return KeywordGroupKeyword[] Returns an array of KeywordGroupKeyword objects
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
    public function findOneBySomeField($value): ?KeywordGroupKeyword
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
