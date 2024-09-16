<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\BlackList;

use App\Models\Subscribes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
    public function register(Request $req) {
        $data = $req->validate([
            'name' => ['required', 'min:3', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8']
        ]);

        $data['password'] = bcrypt($data['password']);  # Hash password
        $user = User::create($data);
        auth()->login($user);

        return redirect('/');
    }

    public function login(Request $req) {
        $data = $req->validate([
            'loginemail' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt(['email' => $data['loginemail'],'password' => $data['loginpassword']])) {
            $req->session()->regenerate();
            return redirect('/');
        }

        // Authentication failed
        return back()->withErrors([
            'login_error' => 'Login failed.',
        ])->withInput($req->only('loginemail'));
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function getUser($id) {
        $data = [
            'user' => User::findOrFail($id),
            'posts' => Post::where('user_id', $id)->get(),
            'subscribed_on' => false
        ];

        return view('user', $data);
    }
}