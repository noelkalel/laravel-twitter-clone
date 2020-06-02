@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between">
        @auth
            <div class="col-2">
                @include('layouts.partials.sidebar')
            </div>
        @endauth

        <div class="col-sm-8">
            <div class="border border-primary p-2 mb-4 rounded">
                <form action="{{ route('tweets.store') }}" method="POST">
                    @csrf

                    <textarea 
                        id="textarea"
                        name="body" 
                        maxlength="255"
                        class="w-100 form-control mb-1" 
                        placeholder="What's up?" 
                        rows="4"></textarea>
                        
                    <span id="rchars">255 </span> Character(s) Remaining  <br>

                    {{-- <input class="mt-1 mb-1 @error('photo') is-invalid @enderror" type="file" name="photo"> --}}

                    <div class="d-flex justify-content-between mt-1">
                        <img src="{{ auth()->user()->avatar }}" alt="" class="rounded-circle mr-2" width="40" height="40">

                        <button type="submit" class="btn btn-primary btn-sm">
                            Tweet Me
                        </button>
                    </div>
                </form>

                @error('body')
                    <div class="mt-2" style="color: red">{{ $message }}</div>
                @enderror
            </div>
            
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
                                
                                <p>
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