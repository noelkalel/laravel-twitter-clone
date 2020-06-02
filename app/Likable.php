<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

trait Likable
{   
    public function scopeWithLikes(Builder $query)
    {
        $query->leftJoinSub(
            'select tweet_id, sum(liked) likes, sum(!liked) dislikes from likes group by tweet_id',
            'likes',
            'likes.tweet_id',
            'tweets.id'
        );
    }
    
    public function likes() // check all likes for certain user $user->likes;
    {
        return $this->hasMany(Like::class);    
    }

    public function like($user = null) // like tweet
    {   
        $this->likes()->updateOrCreate([
            'user_id' => auth()->id()
        ], [
            'liked' => true
        ]);  

        // return $this->likes()->create([
        //     'user_id' => auth()->id(),
        //     'liked' => true
        // ]);
    }

    public function dislike($user = null) // dislike tweet
    {
        $this->likes()->updateOrCreate([
            'user_id' => $user ? $user->id : auth()->id()
        ], [
            'liked' => false
        ]);   

        // return $this->likes()->create([
        //     'user_id' => auth()->id(),
        //     'liked' => false
        // ]);
    }

    public function isLikedBy(User $user) // count of liked votes
    {
        return $user->likes
            ->where('tweet_id', $this->id)
            ->where('liked', true)
            ->count();
    }

    public function isDislikedBy(User $user) // count of disliked votes
    {
        return $user->likes
            ->where('tweet_id', $this->id)
            ->where('liked', false)
            ->count();
    } 

    public function isLikedByOwner() //check if user has liked vote or not, if true returns model if false null
    {
        return $this->likes
            ->where('user_id', auth()->id())
            ->where('tweet_id', $this->id)
            ->where('liked', true)
            ->first();    
    }

    public function isDislikedByOwner() //check if user has disliked vote or not, if true returns model if false null
    {
        return $this->likes
            ->where('user_id', auth()->id())
            ->where('tweet_id', $this->id)
            ->where('liked', false)
            ->first();   
    }   
}