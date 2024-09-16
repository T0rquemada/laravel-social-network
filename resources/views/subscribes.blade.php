<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subscribes</title>
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
                $user = User::where('id', $user['user_id'])->get()[0];
            @endphp

            <div class="card">
                <a href="/user/{{$user['id']}}">{{$user['name']}}</a>
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