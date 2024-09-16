<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Subscribes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {

    // Redirects to '/' if current user is not author of post or not logged in
    private function checkPostAuthor($post) {
        if(auth()->check()) {
            $current_user_id = auth()->user()->id;
        
            if ($current_user_id !== $post['user_id']) {
                return redirect('/');
            }
        } else {
            return redirect('/')->with('error', 'You need to be logged in to perform this action.');
        }

        return null;
    }

    private function fetchPostsFromSubscribed($usersId) {
        $allPosts = [];

        foreach ($usersId as $userId) {
            $posts = Post::with('user')->where('user_id', $userId)->get();
        
            $allPosts = array_merge($allPosts, $posts->toArray());
        }
        
        return $allPosts; 
    }

    public function createPost(Request $req) {
        $data = $req->validate([
            'text' => 'required'
        ]);

        $data['text'] = strip_tags($data['text']);  # Remove html/php tags from string
        $data['user_id'] = auth()->id();

        Post::create($data);

        return redirect('/');
    }

    # Redirect user to edit selected post page
    public function showEditPost(Post $post) {
        if ($redirect = $this->checkPostAuthor($post)) return $redirect;

        return view('edit-post', ['post' => $post]);
    }

    # Saves changes to post
    public function editPost(Post $post, Request $req) {
        if ($redirect = $this->checkPostAuthor($post)) return $redirect;

        $data = $req->validate(['text' => 'required']);
        $data['text'] = strip_tags($data['text']);

        $post->update($data);
        return redirect('/');
    }
    
    public function deletePost($id) {
        $post = Post::findOrFail($id);

        if ($redirect = $this->checkPostAuthor($post)) return $redirect;

        $post->delete();
        return redirect('/');
    }

    public function getPostsFromSubscribes() {
        $current_user_id = Auth::id();

        $current_user_name = User::where('id', $current_user_id)->value('name');

        # Array of id users, on which current user subscribed
        $subscribed_on = Subscribes::where('subscribed_id', $current_user_id)
                                       ->pluck('user_id')
                                       ->toArray();

        $posts = [];

        if (!empty($subscribed_on)) {
            # Fetch all posts users, on which current user subscribed
            $posts = $this->fetchPostsFromSubscribed($subscribed_on);

            $posts = collect($posts);

            # Add to every posts 'author' field
            $posts->transform(function ($post) {
                $post['author'] = $post['user']['name'];
                return $post;
            });
        }

        return view('subscribes-posts', ['posts' => $posts, 'username' => $current_user_name]);
    }
}