<?php

use App\Models\Post;
use App\Models\User;
use App\Models\BlackList;
use App\Models\Subscribes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\SubscribesController;

Route::get('/', function () {
    $posts = Post::with('user')->get();
    
    // Add the 'author' key to each post
    $posts->transform(function ($post) {
        $post['author'] = $post['user']['name'];
        return $post;
    });


    return view('home', ['posts' => $posts]);
});

# User
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/user/{id}', [UserController::class, 'getUser'])->name('user.view');

# Black list
Route::delete('/unblock-user/{id}', [BlacklistController::class, 'unblockUser']);
Route::post('/addToBlacklist/{id}', [BlacklistController::class, 'addToBlacklist']);
Route::get('/blocked-users/{id}', [BlacklistController::class, 'getBlockedUsers'])->name('blackList.view');

# User's subscribes
Route::post('/subscribe/{id}', [SubscribesController::class, 'subscribe']);
Route::delete('/unsubscribe/{id}', [SubscribesController::class, 'unsubscribe']);
Route::get('/subscribers/{id}', [SubscribesController::class, 'getSubscribes'])->name('subscribes.view');
Route::get('/subscribed/{id}', [SubscribesController::class, 'getSubscribed'])->name('subscribed.view');

# Posts
Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/edit-post/{post}', [PostController::class, 'showEditPost']);
Route::put('/edit-post/{post}', [PostController::class, 'editPost']);
Route::delete('/delete-post/{id}', [PostController::class, 'deletePost']);
Route::get('/get-posts-from-subscribes', [PostController::class, 'getPostsFromSubscribes']);