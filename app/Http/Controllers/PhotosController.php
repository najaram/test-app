<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadPhotoRequest;
use App\Http\Resources\ImageResource;
use Illuminate\Support\Facades\Auth;

class PhotosController extends Controller
{
    public function store(UploadPhotoRequest $request)
    {
        $user = Auth::user();

        $image = $user->uploadImage($request->file('photo'));

        $photo = $user->photos()->create([
            'user_id' => $user->id,
            'title'   => $request->get('title'),
            'path'    => $image['photo'],
            'name'    => $image['name']
        ]);

        $photo->tags()->sync((array) $request->get('tags'));

        return ImageResource::make($photo);
    }
}
