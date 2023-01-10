<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function save(Course $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Course $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findCourses(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'ca', 'l')
            ->join('c.category', 'ca')
            ->join('c.level', 'l')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(16)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Course[] Returns an array of Course objects
     */
    public function findByCategory(string $category): array
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'ca', 'l')
            ->join('c.category', 'ca')
            ->join('c.level', 'l')
            ->andWhere('ca.name = :val')
            ->setParameter('val', $category)
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(16)
            ->getQuery()
            ->getResult();
    }


    /**
     * @param string $level
     * @return array
     */
    public function findByLevel(string $level): array
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'ca', 'l')
            ->join('c.category', 'ca')
            ->join('c.level', 'l')
            ->andWhere('l.name = :val')
            ->setParameter('val', $level)
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(16)
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Course
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
