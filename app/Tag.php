<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name'];

    /**
     * Tag can have many photo.
     *
     * @return BelongsToMany
     */
    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(Photo::class, 'photo_tag', 'tag_id')
            ->withTimestamps();
    }
}
