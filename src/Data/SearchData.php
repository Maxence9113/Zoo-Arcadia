<?php

namespace App\Data;
class SearchData
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var bool
     */
    public $promo = false;

    /**
     * @var null|integer
     */
    public $minPrice;

    /**
     * @var null|integer
     */
    public $maxPrice;

    /**
     * @var Race[]
     */
    public $race = [];
    
    /**
     * @var Habitat[]
     */
    public $habitat = [];
}