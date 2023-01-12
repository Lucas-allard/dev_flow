<?php

namespace App\Data;

use App\Entity\Category;
use App\Entity\Level;

class CourseFilterData
{
    /**
     * @var string|null
     */
    private ?string $q = "";

    /** @var Category|null */
    private ?Category $category = null;

    /** @var Level|null */
    private ?Level $level   = null;

    /** @var int|null */
    private ?int $minPoint = null;

    /** @var int|null */
    private ?int $maxPoint = null;

    /**
     * @var bool
     */
    private ?bool $isRead = false;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getMinPoint(): ?int
    {
        return $this->minPoint;
    }

    public function setMinPoint(?int $minPoint): self
    {
        $this->minPoint = $minPoint;

        return $this;
    }

    public function getMaxPoint(): ?int
    {
        return $this->maxPoint;
    }

    public function setMaxPoint(?int $maxPoint): self
    {
        $this->maxPoint = $maxPoint;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getQ(): ?string
    {
        return $this->q;
    }

    /**
     * @param string|null $q
     */
    public function setQ(?string $q): void
    {
        $this->q = $q;
    }

    /**
     * @return bool
     */
    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    /**
     * @param bool $isRead
     */
    public function setIsRead(?bool $isRead): void
    {
        $this->isRead = $isRead;
    }
}
