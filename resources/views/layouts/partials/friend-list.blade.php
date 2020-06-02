<div class="rounded py-2 px-2" style="background-color: #E7F1F2;">
    <h3 class="font-weight-bold mb-3 text-xl-left">Following</h3>

    <ul class="list-unstyled">
        @forelse(auth()->user()->follows as $user)
            <li class="mb-2">
                <div class="d-flex align-items-center">
                    <a href="{{ route('profile.show', $user->name) }}" class="text-dark font-weight-bold">
                        <img src="{{ $user->avatar }}" alt="" class="rounded-circle mr-2" width="40" height="40">
                    </a>
                    <a href="{{ route('profile.show', $user->name) }}" class="text-dark font-weight-bold">
                        {{ $user->name }}
                    </a>
                </div>
            </li>
        @empty
            <p>No friends yet!</p>
        @endforelse
    </ul>
</div>