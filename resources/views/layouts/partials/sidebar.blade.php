<ul class="list-unstyled">
    <li>
        <a class="font-weight-bold mb-2 d-block" href="{{ route('tweets.index') }}">
            Home
        </a>
    </li>
    <li>
        <a class="font-weight-bold mb-2 d-block" href="{{ route('profile.show', auth()->user()->name) }}">
            Profile
        </a>
    </li>
    <li>
        <a class="font-weight-bold mb-2 d-block" href="{{ route('explore.index') }}">
            Explore Users
        </a>
    </li>
    <li>
        <a class="font-weight-bold mb-2 d-block" 
            href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>

