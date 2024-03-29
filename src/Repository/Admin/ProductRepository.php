<?php

namespace App\Repository\Admin;

use App\Entity\Admin\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllByIdJoinedToCategory(): array
    {
        return $this->createNamedQuery('p')
            ->innerJoin('p.category','c')->addSelect('c')->getQuery()->getOneOrNullResult();
    }

    public function getproduct($id) : array {
        $entityManager = $this->getEntityName();

        $query = $entityManager->createQuery(
            'SELECT p FROM App\Entity\Admin\Product p WHERE p.id = :id ORDER BY p.title ASC'
        )->setParameter('id',$id);

        return $query->execute();
    }
}
