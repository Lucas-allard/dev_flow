<?php

namespace App\Repository;

use App\Entity\Challenge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Challenge>
 *
 * @method Challenge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Challenge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Challenge[]    findAll()
 * @method Challenge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Challenge::class);
    }

    public function save(Challenge $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Challenge $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findChallenges()
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'ca', 'l', 't')
            ->join('c.category', 'ca')
            ->join('c.level', 'l')
            ->leftJoin('c.trophy', 't')
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
