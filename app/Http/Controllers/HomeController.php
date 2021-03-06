<?php

namespace App\Http\Controllers;

use App\Image;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        // create a feed of the latest images posted
        // by all profiles the current user follows

        // get current user
        $user = Auth::user();

        // get all profiles he follows
        $following = $user->following;

        if ($following->count() > 0) {
            // get all images these profiles have posted
            // and order them latest to oldest
            $images = Image::getAllImagesFromProfiles($following);

            return view('index', compact('images'));
        }

        return view('index');
    }


    public function about()
    {
        return view('about');
    }


    public function credits()
    {
        return view('credits');
    }
}
