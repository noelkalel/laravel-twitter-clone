<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {   
        $tweets = auth()->user()->timeline();
        
        return view('tweets.index', compact('tweets'));    
    }

    public function store()
    {
        $attributes = request()->validate(['body' => 'required']);
        
        Tweet::create([
            'user_id' => auth()->id(),
            'body' => $attributes['body']
        ]);    

        return back()->with('success', 'Tweet Published!');
    }

    public function destroy(Tweet $tweet)
    {                   
        // if($tweet->user_id != auth()->id()){
        //     return 'not our';
        // }
        
        $this->authorize('delete', $tweet);

        $tweet->delete();  

        return back()->with('success', 'Tweet Deleted!');
    }
}
