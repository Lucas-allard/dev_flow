<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Repository\FilterableRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class ManagerController extends AbstractController
{
    public function __construct(private FilterableRepositoryInterface $repository)
    {
    }

    /**
     * @param Request $request
     * @param string $name
     * @param object $entity
     * @return bool
     */
    protected function checkToken(Request $request, string $name, object $entity): bool
    {
        $token = $request->query->get("token");

        return $this->isCsrfTokenValid($name . $entity->getId(), $token);
    }

    /**
     * @throws NonUniqueResultException
     */
    protected function hasPrevious(int $id): bool
    {
        $previous = $this->repository->findPrevious($id);

        return $previous !== null;
    }

    /**
     * @throws NonUniqueResultException
     */
    protected function hasNext(int $id): bool
    {
        $next = $this->repository->findNext($id);

        return $next !== null;
    }
}