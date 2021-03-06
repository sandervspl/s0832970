<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Image extends Model
{
    protected $fillable = [
        'user_id',
        'image_uri',
        'title',
        'category_id',
        'created_at',
        'updated_at'
    ];




    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function ratings()
    {
        return $this->belongsToMany(Rating::class);
    }


    public function getLikesCount()
    {
        return Image_Rating::getLikesCountForImage($this->id);
    }


    public function getDislikesCount()
    {
        return Image_Rating::getDislikesCountForImage($this->id);
    }


    public static function getImageByName($image_name)
    {
        return Image::where('image_uri', '=', $image_name)->firstOrFail();
    }


    public static function getAllImagesWithQuery($query)
    {
        return Image::where('title', 'like', '%'.$query.'%')
            ->orWhere('description', 'like', '%'.$query.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }


    public static function getAllImagesFromProfiles($profiles)
    {
        $query = [];

        // grab all profiles and look for their images
        for ($i = 0; $i < count($profiles); $i += 1) {
            $user = User::findOrFail($profiles[$i]->follow_id);

            if ( ! $user->banned) {
                if ($i == 0) {
                    $query = Image::where('user_id', '=', $profiles[$i]->follow_id);
                } else {
                    $query->orWhere('user_id', '=', $profiles[$i]->follow_id);
                }
            }
        }

        // your own pictures should also show up in your feed
        $query->orWhere('user_id', '=', Auth::id());

        // return an ordered list (latest to oldest) of 5
        // or return an empty list if user does not follow any profiles
        return (count($query) > 0) ? $query->orderBy('created_at', 'desc')->paginate(5) : $query;
    }
}
