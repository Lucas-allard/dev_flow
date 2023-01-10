<?php

namespace App\Data;

use App\Entity\Category;
use App\Entity\Course;

class SearchData
{
    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Category[]
     */
    public $categories = [];

    public $

    /**
     * @var null|integer
     */
    public $minPoint;

    /**
     * @var null|integer
     */
    public $maxPoint;

    /**
     * @var boolean
     */
    public $promo = false;

}