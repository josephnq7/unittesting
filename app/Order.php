<?php
/**
 * Created by PhpStorm.
 * User: josephnguyen
 * Date: 2019-09-25
 * Time: 15:41
 */

namespace App;


class Order
{

    protected $products = [];

    public function add(Product $product)
    {
        $this->products[] = $product;
    }

    public function products()
    {
        return $this->products;
    }

    public function total()
    {
        return array_reduce($this->products, function($carry, Product $product) {
            return $carry + $product->cost();
        });
    }
}