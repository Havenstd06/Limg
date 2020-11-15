<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'email_verified_at', 'password', 'avatar', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
        'webhook_url',
        'email',
        'email_verified_at',
        'domain',
        'style',
        'always_public',
        'always_discover',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUserAvatar()
    {
        return config('app.url').'/'.$this->avatar;
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function uniques()
    {
        return $this->hasMany('App\Unique');
    }

    public function albums()
    {
        return $this->hasMany('App\Album');
    }

    public function isSocialite()
    {
        return (! $this->password) ? true : false;
    }

    public function getAvatarAttribute($value)
    {
        return config('app.url').'/'.$value;
    }
}
