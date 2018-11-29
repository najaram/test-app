<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTagsRequest;
use App\Http\Resources\TagResource;
use App\Tag;

class TagsController extends Controller
{
    public function store(CreateTagsRequest $request)
    {
        $tag = Tag::create([
            'name' => $request->get('name')
        ]);

        return TagResource::make($tag);
    }
}
