<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository implements FilterableRepositoryInterface
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
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $filterData
     * @return array
     */
    public function findBySearch($filterData): array
    {
        $query = $this->createQueryBuilder('c')
            ->select('c', 'ca', 'l')
            ->join('c.category', 'ca')
            ->join('c.level', 'l')
//            ->join('c.userCourses', 'uc')
            ->orderBy('c.createdAt', 'DESC');
        if ($filterData->getQ()) {
            $query = $query
                ->andWhere('c.title LIKE :q')
                ->setParameter('q', $filterData->getQ());
        }
        if ($filterData->getCategory()) {
            $query = $query
                ->andWhere('ca.name = :category')
                ->setParameter('category', $filterData->getCategory()->getName());
        }
        if ($filterData->getLevel()) {
            $query = $query
                ->andWhere('l.name = :level')
                ->setParameter('level', $filterData->getLevel()->getName());
        }
        if ($filterData->getMinPoint()) {
            $query = $query
                ->andWhere('c.points >= :minPoint')
                ->setParameter('minPoint', $filterData->getMinPoint());
        }
        if ($filterData->getMaxPoint()) {
            $query = $query
                ->andWhere('c.points <= :maxPoint')
                ->setParameter('maxPoint', $filterData->getMaxPoint());
        }
        return $query->getQuery()->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findPrevious(int $id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id < :id')
            ->setParameter('id', $id)
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findNext(int $id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id > :id')
            ->setParameter('id', $id)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
