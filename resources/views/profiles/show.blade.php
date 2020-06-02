@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between">
        @auth
            <div class="col-2">
                @include('layouts.partials.sidebar')
            </div>
        @endauth

        <div class="col-sm-8">  
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="font-weight-bold">{{ $user->name }}'s profile</h3>
                    <p>Joined {{ $user->created_at->diffForHumans() }}</p>
                </div>

                <div class="d-flex">
                    @can('edit', $user)
                        <form action="" method="post">
                            @csrf  
                            <a href="{{ route('profile.edit', $user->name) }}" class="btn btn-light btn-sm mr-1">
                                Edit Profile
                            </a>   
                        </form>
                    @endcan
                    
                    @if(!auth()->user()->is($user))
                        <form action="{{ route('follow.store', $user->name) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ auth()->user()->following($user) ? 'Unfollow' : 'Follow Me' }}
                            </button>   
                        </form>
                    @endif
                </div>
            </div>

            <p>{{ $user->overview }}</p>
            
            @include('layouts.success.index')

            @if($tweets->count() > 0)             
                @foreach($tweets as $tweet)
                    <div class="border border-gray p-2 mb-1">
                        <div class="d-flex">
                            <div class="mr-2">
                                <a href="{{ route('profile.show', $tweet->user->name) }}">
                                    <img src="{{ $tweet->user->avatar }}" alt="" class="rounded-circle mr-2" width="40" height="40">
                                </a>
                            </div>

                            <div>
                                <h5 class="font-weight-bold mb-2">
                                    <a href="{{ route('profile.show', $tweet->user->name) }}" class="text-dark">
                                        {{ $tweet->user->name }}
                                    </a> 
                                    <small class="ml-2">{{ $tweet->created_at->diffForHumans() }}</small>
                                </h5>

                                <p class="text-sm">
                                    {{ $tweet->body }}
                                </p>

                                <div class="d-flex align-items-center">
                                    <form action="{{ route('tweets.like.store', $tweet) }}" method="POST">
                                        @csrf

                                        <div class="{{ $tweet->isLikedBy(auth()->user()) ? 'text-primary' : 'text-dark' }}">
                                            <button type="submit" class="btn btn-outline-primary mr-2">
                                                <i class="fa fa-thumbs-up"> {{ $tweet->likes ? : 0 }}</i>
                                            </button>
                                        </div>
                                    </form>
                                    
                                    <form action="{{ route('tweets.like.destroy', $tweet) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <div class="d-flex align-items-center {{ $tweet->isDislikedBy(auth()->user()) ? 'text-primary' : 'text-dark' }}">
                                            <button type="submit" class="btn btn-outline-secondary mr-2">
                                                <i class="fa fa-thumbs-down"> {{ $tweet->dislikes ? : 0 }}</i>
                                            </button>
                                        </div>
                                    </form>
                                    
                                    @can('delete', $tweet)
                                        <form action="{{ route('tweets.destroy', $tweet) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fa fa-trash"> </i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>

                            {{-- <div class="ml-auto">
                                <img src="{{ $tweet->user->avatar }}" alt="" class="rounded-circle" width="100" height="100">
                            </div> --}}
                        </div>   
                    </div>
                @endforeach
            @else
                <p>No tweets atm!</p>
            @endif

            {{ $tweets->links() }}
        </div>
        
        @auth
            <div class="col-2">
                @include('layouts.partials.friend-list')
            </div>
        @endauth
    </div>
@endsection