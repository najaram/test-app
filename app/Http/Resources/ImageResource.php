<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'     => $this->title,
            'file_name' => $this->name,
            'path'      => $this->photo_path,
            'tags'      => $this->photo_tags
        ];
    }
}
