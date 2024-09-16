<?php

namespace App\Http\Controllers;

use App\Models\BlackList;

use App\Models\Subscribes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribesController;

Route::delete('/unsubscribe/{id}', [SubscribesController::class, 'unsubscribe'])->name('subscribes.insubscribe');


class BlacklistController extends Controller {
    protected $subscribesController;

    public function __construct(SubscribesController $subscribesController) {
        $this->subscribesController = $subscribesController;
    }

    public function addToBlacklist($id) {
        $existed = BlackList::where('user_id', $id)
            ->where('blocked_id', Auth::id())
            ->first();

        $subscribed = Subscribes::where('user_id', $id)
            ->where('subscribed_id', Auth::id())
            ->first();

        if (!$existed) {
            if ($subscribed) {
                $this->subscribesController->unsubscribe($id);
            }
            
            $data = [
                'user_id' => Auth::id(),
                'blocked_id' => $id
            ];
    
            BlackList::create($data);
        }

        return redirect('/');
    }

    public function unblockUser($id) {
        $blacklist_id = BlackList::where('blocked_id', $id);
        $blacklist_id->delete();
        $current_user_id = Auth::id();
        return redirect("/blocked-users/$current_user_id");
    }

    public function getBlockedUsers ($id) {
        $data = ['users' => BlackList::where('user_id', $id)->get()];
    
        if (!empty($data)) return view('blackList', $data);
        return redirect("/user/$id");
    }
}
