<!-- Show list of blocked user. Also you can unblock user, if you want -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blacklist</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
    <style>
        .card {
            margin: 0.5rem;
            padding: 0.5rem;
            display: flex; 
            justify-content: space-between; 
            width: 30%; 
            
            border: 1px solid #000;
            border-radius: 5px;
        }
    </style>
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
                $blocked_user = User::where('id', $user['blocked_id'])->get();
            @endphp
                <form class="card" action="/unblock-user/{{$blocked_user[0]['id']}}" method="POST">
                <a href="/user/{{$blocked_user[0]['id']}}">{{$blocked_user[0]['name']}}</a>
                @csrf
                @method('DELETE')
                <button>Unblock user</button>
            </form>
        @endforeach
    </div>
</body>
</html>