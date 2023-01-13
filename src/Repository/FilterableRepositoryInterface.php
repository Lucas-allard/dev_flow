<?php

namespace App\Repository;

use App\Data\FilterData;

interface FilterableRepositoryInterface
{
    public function findBySearch(FilterData $filterData);

    public function findByCategory(string $category);

    public function findByLevel(string $level);
}