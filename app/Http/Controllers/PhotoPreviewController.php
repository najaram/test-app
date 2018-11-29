<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;

class PhotoPreviewController extends Controller
{
    public function preview(Request $request, $id)
    {
        $path = Photo::getImagePreview(
            $id,
            $request->get('width', 200),
            $request->get('height', 200)
        );

        return $path;
    }
}
