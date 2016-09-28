<?php

namespace App\Http\Controllers;

use App\Image;
use App\Image_Rating;
use App\Rating;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RatingController extends Controller
{
    public function rate(Request $request)
    {
        $image_id = $request->get('image_id');
        $rating_id = $request->get('rating_id');
        $rated = $request->get('user_rated');
        $user = Auth::user();

        if ($rated) {
            // remove rating
            Image_Rating::removeRatingFromUser($user->id, $image_id);

            // only remove rating if we click the same rating button
            if ($rated === $rating_id) {
                return Redirect::back();
            }
        }

        $image = Image::findOrFail($image_id);

        // add to image_rating table
        $image->ratings()->attach($rating_id, ['user_id' => $user->id]);

        return Redirect::back();
    }
}
