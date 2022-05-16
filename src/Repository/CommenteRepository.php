<?php

namespace App\Repository;

use App\Entity\Commente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commente[]    findAll()
 * @method Commente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commente::class);
    }
    /**
     * @return Commente[]
     */
    public function findComs(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Commente[] Returns an array of Commente objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Commente
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
