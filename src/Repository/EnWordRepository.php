<?php

namespace App\Repository;

use App\Entity\EnWord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Doctrine\Orm\Paginator;
use App\Entity\User;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

/**
 * @extends ServiceEntityRepository<EnWord>
 *
 * @method EnWord|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnWord|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnWord[]    findAll()
 * @method EnWord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnWordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnWord::class);
    }

    public function save(EnWord $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EnWord $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getCollectionByUser( User $user, int $page = 1, int $itemsPerPage = 10): Paginator
    {
        $firstResult = ($page -1) * $itemsPerPage;

        $queryBuilder = $this->createQueryBuilder("e");
        $queryBuilder->select('e')
            ->where('e.user = :user')
            ->orderBy("e.createdAt", "DESC")
            ->setParameter('user', $user);

        $criteria = Criteria::create()
            ->setFirstResult($firstResult)
            ->setMaxResults($itemsPerPage);
        $queryBuilder->addCriteria($criteria);

        $doctrinePaginator = new DoctrinePaginator($queryBuilder);
        $paginator = new Paginator($doctrinePaginator);

        return $paginator;
    }


//    /**
//     * @return EnWord[] Returns an array of EnWord objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EnWord
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
