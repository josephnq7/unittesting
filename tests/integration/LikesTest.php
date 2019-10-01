<?php
/**
 * Created by PhpStorm.
 * User: josephnguyen
 * Date: 2019-09-28
 * Time: 17:42
 */

class LikesTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;
    /** @test */
    public function a_user_can_like_a_post()
    {
        //given I have a post
        $post = factory(\App\Post::class)->create();

        //and a user
        $user = factory(\App\User::class)->create();

        //and that user is logged in
        $this->actingAs($user);

        //when they like a post
        $post->like();

        //then we should see evidence in the database, and the post should be liked
        $this->assertDatabaseHas('likes', [
           'user_id' => $user->id,
           'likable_id' => $post->id,
           'likable_type' => get_class($post),
        ]);

        $this->assertTrue($post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
        //given I have a post
        $post = factory(\App\Post::class)->create();

        //and a user
        $user = factory(\App\User::class)->create();

        //and that user is logged in
        $this->actingAs($user);

        //when they like a post
        $post->like();
        $post->unlike();

        //then we should see evidence in the database, and the post should be liked
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'likable_id' => $post->id,
            'likable_type' => get_class($post),
        ]);

        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function a_user_may_toggle_a_posts_like_status()
    {
        //given I have a post
        $post = factory(\App\Post::class)->create();

        //and a user
        $user = factory(\App\User::class)->create();

        //and that user is logged in
        $this->actingAs($user);

        //when they like a post
        $post->toggle();
        $this->assertTrue($post->isLiked());

        $post->toggle();
        $this->assertFalse($post->isLiked());

    }

    /** @test */
    public function count_likes_of_a_post()
    {
        $post = factory(\App\Post::class)->create();

        $user = factory(\App\User::class)->create();

        $this->actingAs($user);

        $post->toggle();

        $this->assertEquals(1, $post->getLikesCountAttribute());
    }

}