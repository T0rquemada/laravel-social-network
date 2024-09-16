<header>
    <div>
        <a class="home__link" href="/">Home</a>
        @auth 
            |
            <a href="/user/{{Auth::id()}}">My profile</a>
            |
            <a href="/get-posts-from-subscribes">My subscribes</a>
        @endauth
    </div>
    @auth
        <form action="/logout" method="POST">
            @csrf
            <button>Log out</button>
        </form>
    @endauth
</header>