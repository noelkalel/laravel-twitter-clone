<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(User $user)
    { 
        return view('profiles.show', [
            'user' => $user,
            'tweets' => $user->tweets()->withLikes()->paginate(30)
        ]);
    }

    public function edit(User $user)
    {
        // if(auth()->user()->isNot($user)){
        //     abort(403);
        // }
        $this->authorize('edit', $user);

        return view('profiles.edit', compact('user'));   
    }

    public function update(User $user)
    {   
        $attributes = request()->validate([
            'name' => ['string', 'required', 'max:255'],
            'avatar' => ['file'],
            'email' => ['string', 'required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'password' => ['string', 'required', 'min:4', 'max:255', 'confirmed'],
            'overview' => ['required', 'min:3', 'max:255'],
        ]);

        $attributes['password'] = bcrypt(request('password'));

        if(request('avatar')){
            $attributes['avatar'] = request('avatar')->getClientOriginalName();  // ime slike -> expample: test.jpg 

            $destination = base_path() . '/public/images';  // putanja -> example.com/public/images
            request('avatar')->move($destination, $attributes['avatar']); // file object + putanja + slika
        }
        
        $user->update($attributes);  

        return redirect()->route('profile.show', $user->name); 
    }
}
