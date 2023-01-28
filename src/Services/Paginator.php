<?php

namespace App\Services;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class Paginator
{
    public function __construct(private PaginatorInterface $paginator)
    {
    }

    public function getPaginatedData(Request $request, $data, $limit = 15): PaginationInterface
    {
        return $this->paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $limit
        );
    }

}