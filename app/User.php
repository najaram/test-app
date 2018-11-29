<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function uploadImage($file)
    {
        $name = $file->getClientOriginalName();
        $path = $file->store('local');

        $response = [
            'photo' => $path,
            'name' => $name,
        ];

        return $response;
    }
}
