<?php

namespace App\Repository;

use App\Entity\Tag;
use App\Entity\Post;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Get published posts
     * @param int $page
     * @param Category $category
     * @param Tag $tag
     * @return PaginationInterface
     */
    public function findPublished(int $page, ?Category $category, ?Tag $tag): PaginationInterface
    {
        $query = $this->createQueryBuilder("p")
            ->join("p.categories", "c")
            ->join("p.tags","t")
            ->andWhere("p.state LIKE :state")
            ->setParameter("state", "%STATE_PUBLISHED%")
            ->orderBy("p.createdAt", "DESC");
                      
        
        if ( isset($category) ) {
            $query = $query->andWhere(':category IN (c)')
                           ->setParameter('category', $category);
        }

        if (isset($tag)) {
            $query = $query->andWhere(':tag IN (t)')
                           ->setParameter('tag', $tag);
        }

        $query->getQuery()
              ->getResult();
        $posts = $this->paginatorInterface->paginate(
            $query,
            $page,
            9
        );

        return $posts;
    }

//    /**
//     * @return Post[] Returns an array of Post objects
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

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
