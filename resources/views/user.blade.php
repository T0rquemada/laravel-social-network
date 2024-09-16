<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$user['name']}}'s rofile</title>

        <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/user_page.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/posts.css') }}">
    </head>
    <body>
        <div class="page__container">
            @include('components/header')
            <div class="about__user__container">
                <h2 class="user__name">{{$user['name']}} profile</h2>
                <h4 class="user__created">Signed up at: {{substr($user['created_at'], 0, 10)}}</h4>
                @if (Auth::id() !== $user['id'])
                    <form action="/addToBlacklist/{{$user['id']}}" method="POST">
                        @csrf
                        <button>Add to black list</button>
                    </form>

                    <form action="/subscribe/{{$user['id']}}" method="POST">
                        @csrf
                        <button>Subscribe</button>
                    </form>
                @else
                    <form action="/subscribers/{{$user['id']}}" method="GET">
                        @csrf
                        <button>Subscribers</button>
                    </form>
                    <form action="/subscribed/{{$user['id']}}" method="GET">
                        @csrf
                        <button>Subscribed</button>
                    </form>
                    <form action="/blocked-users/{{$user['id']}}" method="GET">
                        @csrf
                        <button>Blocked users</button>
                    </form>
                @endif
            </div>
            
            <h2>{{$user['name']}}'s posts:</h2>
            @include('components/posts_list')
        </div>
    </body>
</html>
