<?php

namespace App\Data;

use App\Entity\Categories;

class SearchData{
    /**
     * @var string
     */
    public $q = "";

    /**
     * @var Categories[]
     */
    public $category = [];

    /**
     * @var null|integer
     */
    public $max;

    /**
     * @var null|integer
     */
    public $min;

    /**
     * @var boolean
     */
    public $promo;
}