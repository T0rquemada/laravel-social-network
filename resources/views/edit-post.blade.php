<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit post</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form>*{
            margin: 1rem;
        }
        textarea {
            min-width: 50%;
        }
        .btns__container {
            display: flex;
            justify-content: space-between;
        }
        .btn {
            padding: 0.5rem;
            border-radius: 5px;
            border: 1px solid #000;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Edit post</h1>

    <form action="/edit-post/{{$post->id}}" method="POST">
        @csrf
        @method('PUT')
        <textarea name="text">{{$post->text}}</textarea>
        <div class="btns__container">
            <button id="cancelBtn" class="btn">Cancel</button>
            <button class="btn">Save changes</button>
        </div>
    </form>
    
    <script>
        const cancelBtn = document.getElementById('cancelBtn');
        cancelBtn.addEventListener('click', () => {
            window.location.href = '/';
        });
    </script>
</body>
</html>