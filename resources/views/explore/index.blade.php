@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between">
        @auth
            <div class="col-2">
                @include('layouts.partials.sidebar')
            </div>
        @endauth

        <div class="col-sm-8">  
            Explore Users
            <hr>
            
            @foreach($users as $user)
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('profile.show', $user->name) }}" class="text-dark font-weight-bold">
                        <img 
                            {{-- src="{{ $user->avatar ? asset('/images/' . $user->avatar) : asset('/images/default-avatar.jpg') }}"  --}}
                            src="{{ $user->avatar }}" 
                            alt="{{ $user->name }}'s avatar" 
                            class="mr-2 rounded-circle" 
                            width="40" 
                            height="40">
                    </a>
                    <div>
                        <a href="{{ route('profile.show', $user->name) }}" class="text-dark font-weight-bold">
                            <h5 class="mt-2">{{ '@' . $user->name }}</h5>
                        </a>
                    </div>
                </div>
            @endforeach

            {{ $users->links() }}
        </div>
        
        @auth
            <div class="col-2">
                @include('layouts.partials.friend-list')
            </div>
        @endauth
    </div>
@endsection