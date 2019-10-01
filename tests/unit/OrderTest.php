<?php
/**
 * Created by PhpStorm.
 * User: josephnguyen
 * Date: 2019-09-25
 * Time: 15:41
 */

class OrderTest extends PHPUnit\Framework\TestCase
{
    /** @test */
    function an_order_consists_of_products()
    {
        $order = new \App\Order();

        $product1 = new \App\Product('Fallout 4', 59);
        $product2 = new \App\Product('Pillowcase', 7);

        $order->add($product1);
        $order->add($product2);

        $this->assertCount(2, $order->products());
    }

    /** @test */
    function an_order_can_determine_the_total_cost_of_all_its_products()
    {
        $order = new \App\Order();

        $product1 = new \App\Product('Fallout 4', 59);
        $product2 = new \App\Product('Pillowcase', 7);

        $order->add($product1);
        $order->add($product2);

        $this->assertEquals(66, $order->total());
    }
}