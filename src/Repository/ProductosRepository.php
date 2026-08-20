<?php

namespace App\Repository;

use App\Entity\Productos;
use Dba\Connection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Productos>
 *
 * @method Productos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Productos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Productos[]    findAll()
 * @method Productos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Productos::class);
    }

    public function findProductsWithCategory($productId = null) {        
        $qb = $this->createQueryBuilder('p')
            ->select("
                p.nombre as producto,
                c.nombre as categoria,
                p.descripcion,
                p.imagen,
                p.precio,
                p.stock
            ")
            ->innerJoin('p.categoria', 'c');
            
            if ($productId !== null) {
                $qb->where('p.id = :productId')
                ->setParameter('productId', $productId);
            }
        
            return $qb->getQuery()->getArrayResult();
    }

    public function serchAll(string $like) {        
        return $this->createQueryBuilder('p')
            ->select("
                p.id as idproducto,
                c.id as idcategoria,
                p.nombre as producto,
                c.nombre as categoria
            ")
            ->innerJoin('p.categoria', 'c')
            ->where('p.nombre LIKE :search OR c.nombre LIKE :search')
            ->setParameter('search', '%' . $like . '%')
            ->getQuery()
            ->getArrayResult();
    }

    /*
  $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Product p
            WHERE p.price > :price
            ORDER BY p.price ASC'
        )->setParameter('price', $price);

        // returns an array of Product objects
        return $query->getResult();

    */

//    /**
//     * @return Productos[] Returns an array of Productos objects
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

//    public function findOneBySomeField($value): ?Productos
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
