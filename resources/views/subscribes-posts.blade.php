<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $username }} subscribes</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/posts.css') }}">
</head>
<body>
    <div class="page__container">
        @auth
            @include('components/header')
            <main>
                @if(!empty($posts))
                    @include('components/posts_list')
                @else
                <p>You don't have any subscriptions!</p>
                @endif
            </main>
        @else
            <p>You should be signed!</p>
        @endauth
    </div>
</body>
</html>