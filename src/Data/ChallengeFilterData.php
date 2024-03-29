<?php

namespace App\Data;

use App\Entity\Category;
use App\Entity\Level;
use DateTimeInterface;

class ChallengeFilterData implements FilterDataInterface
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


    private ?DateTimeInterface $startDate = null;

    private ?DateTimeInterface $endDate = null;

    private ?bool $hasTrophy = null;


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
     * @return DateTimeInterface|null
     */
    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param DateTimeInterface|null $startDate
     * @return ChallengeFilterData
     */
    public function setStartDate(?DateTimeInterface $startDate): ChallengeFilterData
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param DateTimeInterface|null $endDate
     * @return ChallengeFilterData
     */
    public function setEndDate(?DateTimeInterface $endDate): ChallengeFilterData
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getHasTrophy(): ?bool
    {
        return $this->hasTrophy;
    }

    /**
     * @param bool|null $hasTrophy
     */
    public function setHasTrophy(?bool $hasTrophy): void
    {
        $this->hasTrophy = $hasTrophy;
    }

}
