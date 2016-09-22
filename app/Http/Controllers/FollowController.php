<?php

namespace App\Http\Controllers;

use Auth;
use App\Follow;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $follow = new Follow;
        $follow->user_id = Auth::id();
        $follow->follow_id = $request->get('follow_id');
        $follow->save();

        return Redirect::back();
    }

    public function unfollow(Request $request)
    {
        $followid = $request->get('follow_id');
        $follow = Follow::where('user_id', Auth::id())->where('follow_id', $followid)->first();

        if ($follow) {
            Follow::destroy($follow->id);
        }

        return Redirect::back();
    }

    public function follows()
    {
        return $this->belongsToMany('App\User', 'follows', 'user_id', 'follows_id');
    }

    // wordt hasMany
    public function followers()
    {
        return $this->belongsToMany('App\User', 'follows', 'follows_id', 'user_id');
    }
}
