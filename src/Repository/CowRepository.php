<?php

namespace App\Repository;

use App\Entity\Cow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cow>
 *
 * @method Cow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cow[]    findAll()
 * @method Cow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cow::class);
    }

    public function save(Cow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Finds all the public recipes based on the number of cows
     *
     * @param integer $nbCows
     * @return array
     */
    public function findPublicCow(?int $nbCows):array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.isPublic = 1')
            ->orderBy('c.dob', 'DESC');
    
        if(!$nbCows === 0 || !$nbCows ===null){
            $queryBuilder->setMaxResults($nbCows);
        }
          return $queryBuilder ->getQuery()
                     ->getResult();
    }

//    /**
//     * @return Cow[] Returns an array of Cow objects
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

//    public function findOneBySomeField($value): ?Cow
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
