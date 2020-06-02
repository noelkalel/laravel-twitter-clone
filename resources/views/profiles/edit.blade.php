@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between">
        @auth
            <div class="col-2">
                @include('layouts.partials.sidebar')
            </div>
        @endauth

        <div class="col-sm-8">
            {{ ucfirst($user->name) }} profile <hr>

            <form action="{{ route('profile.update', $user->name) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name">Name</label>
                    <input type="text" class="form-control col-6 mb-3 @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div>
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control col-6 mb-3 @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" class="form-control col-6 mb-3 @error('password') is-invalid @enderror" name="password" required autocomplete="password" autofocus>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control col-6 mb-3" name="password_confirmation" required autocomplete="password_confirmation">
                </div>
                
                <div>
                    <label for="overview">Overview</label>
                    <textarea 
                        id="textarea"
                        name="overview" 
                        class="form-control col-6 mb-3 @error('overview') is-invalid @enderror"
                        rows="4">{{ $user->overview }}</textarea>

                    @error('overview')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="avatar">Avatar</label><br>
                    <input class="mb-2 @error('avatar') is-invalid @enderror" type="file" name="avatar"><br>
                    <img src="{{ $user->avatar }}" alt="your avatar" class="rounded-circle mr-2 mb-2" width="40" height="40">

                    @error('avatar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-primary mr-2">
                        Confirm
                    </button>

                    <a href="{{ route('profile.show', $user->name) }}" class="btn btn-success">Cancel</a>
                </div>
            </form>
        </div>
            
        @auth
            <div class="col-2">
                @include('layouts.partials.friend-list')
            </div>
        @endauth
    </div>
@endsection