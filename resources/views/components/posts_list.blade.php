<div class="posts__list">
    @foreach($posts as $post)
        <!-- Check, if author post is not blocked by current user-->
        @php  
            $isBlocked = \App\Models\BlackList::where('user_id', Auth::id())
                                            ->where('blocked_id', $post['user_id'])
                                            ->exists();
        @endphp

        @if (!$isBlocked)
            <div class="post__container">
                <div class="post__header">
                    <div class="post__author"><a href={{ route("user.view", ['id' => $post['user_id']])}}>{{$post['author']}}</a></div>
                </div>

                <div class="post__body">
                    <div calss="post__text">{{$post['text']}}</div>
                </div>

                <div class="post__footer">
                    <div class="post__data">{{substr($post['created_at'], 0, 10)}}</div>
                    <!-- If current user is author post, add edit/delete button-->
                    @if(Auth::id() === $post['user_id'])
                    <form action="/delete-post/{{$post['id']}}" method="POST" class="post__delete__form">
                        @csrf
                        @method('DELETE')
                        <button>Delete post</button>
                    </form>

                    <button><a href="/edit-post/{{$post['id']}}">Edit post</a></button>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>