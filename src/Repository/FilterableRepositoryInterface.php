<?php

namespace App\Repository;

use App\Data\ChallengeFilterData;

interface FilterableRepositoryInterface
{
    public function findBySearch(ChallengeFilterData $filterData);

    public function findByCategory(string $category);

    public function findByLevel(string $level);

    public function findPrevious(int $id);

    public function findNext(int $id);

    public function findByCategoryOrLevel(?string $entity);
}