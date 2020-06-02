<?php

namespace App;

trait Followable
{
    public function follows() // check users friends
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id');    
    }

    // public function toggleFollow($value)
    // {
    //     // if($this->following($value)){
    //     //     return $this->unfollow($value);
    //     // }

    //     // return $this->follow($value);

    //     $this->follows()->toggle($value);
    // }

    public function follow($value) // $user->follow();
    {
        return $this->follows()->attach($value);    
    }

    public function unfollow($value) // $user->unfollow();
    {
        return $this->follows()->detach($value);    
    }

    public function following(User $user) // check if user follow certain user
    {   
        return $this->follows()->where('follow_id', $user->id)->count();    
    }
}