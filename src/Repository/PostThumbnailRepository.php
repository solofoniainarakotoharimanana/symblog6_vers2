<?php

namespace App\Repository;

use App\Entity\PostThumbnail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostThumbnail>
 *
 * @method PostThumbnail|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostThumbnail|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostThumbnail[]    findAll()
 * @method PostThumbnail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostThumbnailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostThumbnail::class);
    }

//    /**
//     * @return PostThumbnail[] Returns an array of PostThumbnail objects
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

//    public function findOneBySomeField($value): ?PostThumbnail
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
