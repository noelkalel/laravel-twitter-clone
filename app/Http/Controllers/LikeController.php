<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Tweet $tweet)
    { 
        if($tweet->isLikedByOwner()){
            $tweet->isLikedByOwner()->delete();

            return back()->with('success', 'Your like was removed!');
        }

        $tweet->like();

        return back()->with('success', 'Tweet Liked!');
    }

    public function destroy(Tweet $tweet)
    {         
        if($tweet->isDislikedByOwner()){
            $tweet->isDislikedByOwner()->delete();

            return back()->with('success', 'Your dislike was removed!');
        }

        $tweet->dislike();

        return back()->with('success', 'Tweet Disliked!');
    }
}
