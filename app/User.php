<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, Followable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function likes() 
    {
        return $this->hasMany(Like::class);
    }

    public function getAvatarAttribute($value) // $user->avatar;
    {
        return $value ? asset('/images/' . $value) : asset('/images/default-avatar.jpg');
    }

    public function tweets() // $user->tweets();
    {
        return $this->hasMany(Tweet::class)->latest();    
    }

    public function timeline() // user + users followers tweets
    {
        $friendsId = $this->follows()->pluck('id'); 

        return Tweet::whereIn('user_id', $friendsId)
            ->orWhere('user_id', $this->id)
            ->withLikes()
            ->latest()
            ->paginate(30);    
    }
}
