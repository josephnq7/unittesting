<?php



class TeamTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;
    /** @test */
    public function a_team_has_a_name()
    {
        $team = new \App\Team(['name' => 'Acme']);

        $this->assertEquals('Acme', $team->name);
    }

    /** @test */
    public function a_team_can_add_members()
    {
        $team = factory(\App\Team::class)->create();

        $user = factory(\App\User::class)->create();
        $user2 = factory(\App\User::class)->create();

        $team->add($user);
        $team->add($user2);

        $this->assertEquals(2, $team->count());

//        \App\Team::truncate();
    }

    /** @test */
    public function a_team_has_a_maximum_size()
    {
        $team = factory(\App\Team::class)->create(['size' => 2]);

        $user1 = factory(\App\User::class)->create();
        $user2 = factory(\App\User::class)->create();

        $team->add($user1);
        $team->add($user2);

        $this->assertEquals(2, $team->count());

        $this->expectException('Exception');
        $user3 = factory(\App\User::class)->create();

        $team->add($user3);
    }

    /** @test */
    public function a_team_can_add_multiple_members_at_once()
    {
        $team = factory(\App\Team::class)->create();

        $users = factory(\App\User::class, 2)->create();

        $team->add($users);

        /** @var \Illuminate\Database\Eloquent\Collection  $users*/
        //remove subset of collection
//        $team->remove($users->slice(0, 2));

        $this->assertEquals(2, $team->count());
    }

    /** @test */
    public function when_adding_many_members_at_once_you_still_may_not_exceed_the_team_maximum_size()
    {
        $team = factory(\App\Team::class)->create(['size' => 2]);

        $users = factory(\App\User::class, 3)->create();

        $this->expectException('Exception');

        $team->add($users);
    }

}
