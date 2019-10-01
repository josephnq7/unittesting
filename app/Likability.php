<?php
/**
 * Created by PhpStorm.
 * User: josephnguyen
 * Date: 2019-09-29
 * Time: 13:22
 */

namespace App;

use Illuminate\Support\Facades\Auth;


trait Likability
{
    public function like()
    {
        $like = new Like(['user_id' => Auth::id()]);

        $this->likes()->save($like);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function isLiked()
    {
        return !! $this->likes()
            ->where('user_id', Auth::id())
            ->count();
    }

    public function unlike()
    {
        $this->likes()->where('user_id', Auth::id())->delete();
    }

    public function toggle()
    {
        if ($this->isLiked()) {
            $this->unlike();
        } else {
            $this->like();
        }
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}