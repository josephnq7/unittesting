<?php
/**
 * Created by PhpStorm.
 * User: josephnguyen
 * Date: 2019-09-25
 * Time: 16:17
 */

use \App\Article;

class ArticleTest extends TestCase
{

    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    /** @test */
    function it_fetches_trending_articles()
    {

        // Given
        factory(\App\Article::class, 3)->create();
        factory(\App\Article::class)->create(['reads' => 10]);
        $mostPopular = factory(\App\Article::class)->create(['reads' => 20]);

        // When

        $articles = Article::trending(2);

        // Then
        $this->assertEquals($mostPopular->id, $articles->first()->id);
        $this->assertCount(2, $articles);

//        Article::truncate();
    }
}