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

    public function getSubscribes () {
        $subscribers = ['users' => Subscribes::where('user_id', Auth::id())->get()];
    
        if (!empty($subscribers)) return view('subscribes', $subscribers);
        $id = Auth::id();
        return redirect("/user/$id");
    }

    public function getSubscribed() {
        $subscribed = ['users' => Subscribes::where('subscribed_id', Auth::id())->get()];
    
        if (!empty($subscribed)) return view('subscribes', $subscribed);
        $id = Auth::id();
        return redirect("/user/$id");
    }
}
