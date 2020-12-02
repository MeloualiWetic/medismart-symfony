<?php

namespace App\Repository;

use App\Entity\DetailConsultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailConsultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailConsultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailConsultation[]    findAll()
 * @method DetailConsultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailConsultation::class);
    }

     /**
      * @return DetailConsultation[] Returns an array of DetailConsultation objects
      */
    public function findByConsultationId($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.consultation_id = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?DetailConsultation
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
