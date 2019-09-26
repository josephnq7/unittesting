<?php
/**
 * Created by PhpStorm.
 * User: josephnguyen
 * Date: 2019-09-23
 * Time: 15:24
 */

namespace App;


class Product
{
    protected $name;
    protected $cost;

    public function __construct($name, $cost)
    {
        $this->name = $name;
        $this->cost = $cost;
    }

    public function name()
    {
        return $this->name;
    }

    public function cost()
    {
        return $this->cost;
    }
}