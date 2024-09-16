<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/posts.css') }}">
</head>
<body>
    <div class="page__container">
        @auth
            @include('components/header')

            <form class="create__posts__form" action="/create-post" method="POST">
                @csrf
                <textarea name="text" placeholder="Post content..."></textarea>
                <button>Create post</button>
            </form>
        @else
            <div style="border: 2px solid #000; padding: 1rem;">
                <h2>Register</h2>
                <form action="/register" method="POST">
                    @csrf
                    <input name="name" placeholder="name" type="text">
                    <input name="email" placeholder="email" type="text">
                    <input name="password" placeholder="password" type="password">
                    <button>Register</button>
                </form>
                
                @if (!$errors->has('login_error') && $errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div style="border: 2px solid #000; padding: 1rem; margin: 1rem 0;">
                <h2>Log in</h2>
                <form action="/login" method="POST">
                    @csrf
                    <input name="loginemail" placeholder="email" type="text">
                    <input name="loginpassword" placeholder="password" type="password">
                    <button>Log in</button>
                </form>
                @if ($errors->has('login_error'))
                    <div style="color: red;">
                        {{ $errors->first('login_error') }}
                    </div>
                @endif
            </div>
        @endauth

        <main>
            <h2>All posts</h2>
            @include('components/posts_list')
        </main>
    </div>
</body>
</html>