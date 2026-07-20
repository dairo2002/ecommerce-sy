<?php

namespace App\Repository;

use App\Entity\Carritocompras;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Carritocompras>
 *
 * @method Carritocompras|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carritocompras|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carritocompras[]    findAll()
 * @method Carritocompras[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarritocomprasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carritocompras::class);
    }

//    /**
//     * @return Carritocompras[] Returns an array of Carritocompras objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Carritocompras
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
