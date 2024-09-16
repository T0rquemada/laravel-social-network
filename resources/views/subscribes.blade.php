<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subscribes</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
</head>
<body>
    @php
        use App\Models\User; 
    @endphp

    <div class="page__container">
        @auth   
            @include('components/header')
        @endauth

        @foreach ($users as $user)
            @php
                $user = User::where('id', $user['user_id'])->get()[0];
            @endphp

            <div>{{$user}}</div>
            <div>
                <a href="/user/{{$user['id']}}">{{$user['name']}}</a>
                <div>{{$user['id']}}</div>
                <form action="/unsubscribe/{{$user['id']}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button>Unsubscribe</button>
                </form>
            </div>
            
        @endforeach
    </div>
</body>
</html>