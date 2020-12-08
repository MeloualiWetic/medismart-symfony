<?php

namespace App\Repository;

use App\Entity\Consultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Consultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultation[]    findAll()
 * @method Consultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultation::class);
    }

     /**
      * @return Consultation[] Returns an array of Consultation objects
      */

    public function countConsultation()
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }


    /**
     * @return Consultation[] Returns an array of Consultation objects
     */
    public function countConsultationByMonth()
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id) as count,MONTH(c.dateDebut) as byMonth')
            ->groupBy('byMonth')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return Consultation[] Returns an array of Consultation objects
     */
    public function findConsultationByUtilisateur($value)
    {
        return $this->createQueryBuilder('c')
//            ->select('c')
            ->andWhere('c.utilisateur = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }

}
