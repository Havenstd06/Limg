<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'name', 'slug', 'user_id',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function images()
    {
        return $this->belongsToMany('App\Image');
    }

    public static function search($query)
    {
        return static::select('albums.*')
            ->join('users', 'user_id', '=', 'users.id')
            ->where('users.username', 'LIKE', '%'.$query.'%')
            ->orWhere('name', 'LIKE', '%'.$query.'%')
            ->orWhere('slug', 'LIKE', '%'.$query.'%')
            ->orWhere('albums.created_at', 'LIKE', '%'.$query.'%');
    }

    public static function userSearch($query, $user)
    {
        return empty($query) ? static::where('user_id', $user->id) :
            static::where([
                ['user_id', $user->id],
                ['id', 'LIKE', '%'.$query.'%'],
            ])
            ->orWhere([
                ['user_id', $user->id],
                ['name', 'LIKE', '%'.$query.'%'],
            ])
            ->orWhere([
                ['user_id', $user->id],
                ['slug', 'LIKE', '%'.$query.'%'],
            ])
            ->orWhere([
                ['user_id', $user->id],
                ['created_at', 'LIKE', '%'.$query.'%'],
            ]);
    }
}
