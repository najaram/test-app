<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Photo;
use Illuminate\Http\Request;

class PhotosSearchController extends Controller
{
    public function search(Request $request)
    {
        $tags = $request->get('tags');

        $photo = Photo::whereHas('tags', function ($query) use ($tags) {
            $query->whereName($tags);
        })->get();

        return ImageResource::collection($photo);
    }
}
