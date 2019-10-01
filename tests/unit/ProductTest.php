<?php
/**
 * Created by PhpStorm.
 * User: josephnguyen
 * Date: 2019-09-23
 * Time: 15:25
 */

use App\Product;

class ProductTest extends PHPUnit\Framework\TestCase
{

    /**
     * @var Product
     */
    protected $product;

    public function setUp()
    {
        $this->product = new Product('Fallout 4', 59);
    }

    /**
     * @test
     */
    function aProductHasName()
    {

        $this->assertEquals('Fallout 4', $this->product->name());
    }

    function testAProductHasCost()
    {
        $this->assertEquals(59, $this->product->cost());
    }
}