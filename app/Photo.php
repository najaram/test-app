<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $guarded = [];

    public function getPhotoPathAttribute($value)
    {
        return env('APP_URL') . 'photo/' . $this->id . '/preview/';
    }

    public function getPhotoTagsAttribute($value)
    {
        return $this->tags->pluck('name');
    }
    
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        $this->belongsTo(User::class);
    }

    /**
     * Photo can have many tags.
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'photo_tag', 'photo_id')
            ->withTimestamps();
    }

    /**
     * Add tag to photo.
     *
     * @param Tag $tag
     */
    public function tag(Tag $tag)
    {
        if (!$this->hasTag($tag)) {
            $this->tags()->sync($tag);
        }
    }

    /**
     * Check if photo has the tag.
     *
     * @param Tag $tag
     * @return bool
     */
    public function hasTag(Tag $tag)
    {
        return (bool) $this->tags()->where('tag_id', $tag->id)->count();
    }

    /**
     * Get image preview.
     *
     * @param $query
     * @param $id
     * @param $width
     * @param $height
     * @return mixed
     * @throws \Exception
     */
    public function scopeGetImagePreview($query, $id, $width, $height)
    {
        $photo = $query->find($id);

        if (!$photo) {
            throw new \Exception('Unable to find photo image');
        }

        $path = Storage::disk('local')->path($photo->path);

        $image = Image::make($path)->fit($width, $height, function ($constraint) {

        });

        return $image->response();
    }
}
