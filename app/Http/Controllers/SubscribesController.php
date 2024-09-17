<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use App\Models\Subscribes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscribesController extends Controller {
    public function subscribe($id) {

        $existed = Subscribes::where('user_id', $id)
            ->where('subscribed_id', Auth::id())
            ->first();

        $blocked = BlackList::where('user_id', $id)
            ->where('blocked_id', Auth::id())
            ->first();

        if (!$existed && !$blocked) {
            $data = [
                'user_id' => $id, 
                'subscribed_id' => Auth::id()
            ];
    
            Subscribes::create($data);
        }

        return redirect("/user/$id");
    }

    public function unsubscribe($id) {
        $current_user_id = Auth::id();

        $subscribe = Subscribes::where('user_id', $id)
                                    ->where('subscribed_id', $current_user_id)
                                    ->first();

        if ($subscribe) $subscribe->delete();
        else return redirect()->back()->with('error', 'Subscription not found or you do not have permission to unsubscribe.');
        
        return redirect("/subscribed/$current_user_id");
    }

    // Return users, which subscribed on current user 
    public function getSubscribes () {
        $subscribers = Subscribes::where('user_id', Auth::id())
                            ->with('user') // Load user relation
                            ->get();
    
        return view('subscribes', ['subscribers' => $subscribers]);
    }

    // Return users, on which current user subscribed
    public function getSubscribed() {
        $subscribed = Subscribes::where('subscribed_id', Auth::id())
                            ->with('user')
                            ->get();
    
        return view('subscribed', ['subscribed' => $subscribed]);
    }
}
