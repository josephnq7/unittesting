<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name'];

    public function add($user)
    {
        //guard
        $this->guardAgainstTooManyMembers();

        if ($user instanceof User) {
            $this->members()->save($user);
        } else {
            $this->members()->saveMany($user);
        }
    }

    public function remove($user = null)
    {
        if (!$user) {
            return $this->members()->update(['team_id' => null]);
        }

        if ($user instanceof User) {
            $user->leaveTeam();
        } else {
            //remove a list of users

            $userIds = $user->pluck('id');
            $this->members()->whereIn('id', $userIds)->update(['team_id' => null]);
        }

    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function count()
    {
        return $this->members()->count();
    }

    protected function guardAgainstTooManyMembers()
    {
        if ($this->count() >= $this->size) {
            throw new \Exception();
        }
    }
}
