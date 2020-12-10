<?php

namespace App\Repository;

use App\Entity\Consultation;
use App\Entity\Prestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prestation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestation[]    findAll()
 * @method Prestation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestation::class);
    }

     /**
      * @return Prestation[] Returns an array of Prestation objects
      */

    public function countPrestatoin()
    {
        return $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
    /**
     * @return Prestation[] Returns an array of Prestation objects
     */
    public function findNoDeletedPrestation()
    {
        return $this->createQueryBuilder('p')
//            ->select('c')
            ->andWhere('p.isDeleted = :val')
            ->setParameter('val', 0)
            ->getQuery()
            ->getResult()
            ;
    }


//    /**
//     * @override
//     * @return Prestation[] Returns an array of Consultation objects
//     */
//   public function findAll()
//   {
//       return $this->createQueryBuilder('p')
//           ->andWhere('p.isDeleted = :val')
//           ->setParameter('val', 0)
//           ->getQuery()
//           ->getResult()
//           ;
//       ;
//   }


    /*
    public function findOneBySomeField($value): ?Prestation
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
