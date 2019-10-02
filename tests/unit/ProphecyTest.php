<?php
/**
 * Created by PhpStorm.
 * User: josephnguyen
 * Date: 2019-10-01
 * Time: 15:33
 */

class ProphecyTest extends PHPUnit\Framework\TestCase
{
    function test_something()
    {
        $directive = $this->prophesize(BladeDirective::class);

        //expected the foo method WILL be called.
        $directive->foo('bar')->shouldBeCalled()->willReturn('foobar');

//        die(var_dump($directive->reveal()));

        $response = $directive->reveal()->foo('bar');

        $this->assertEquals('foobar', $response);
    }

    /** @test */
    function it_normalizes_a_string_for_the_cache_key()
    {
        $cache = $this->prophesize(RussianCache::class);
        $directive = new BladeDirective($cache->reveal());

        $cache->has('cache-key')->shouldBeCalled();

        $directive->setUp('cache-key');
    }

    /** @test */
    function it_normalizes_a_cacheable_model_for_the_cache_key()
    {
        $cache = $this->prophesize(RussianCache::class);
        $directive = new BladeDirective($cache->reveal());

        $cache->has('stub-cache-key')->shouldBeCalled();

        $directive->setUp(new ModelStub());
    }

}

class ModelStub
{
    public function getCacheKey()
    {
        return 'stub-cache-key';
    }
}

class BladeDirective
{

    protected $cache;

    public function __construct(RussianCache $cache)
    {
        $this->cache = $cache;
    }

    public function foo()
    {

    }

    public function setUp($key)
    {
        $this->cache->has(
            $this->normalizeKey($key)
        );
    }

    protected function normalizeKey($item)
    {
        if (is_object($item) && method_exists($item, 'getCacheKey')) {
            return $item->getCacheKey();
        }

        return $item;
    }

}

class RussianCache
{
    public function has()
    {

    }
}