<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    protected $fillable = ['title', 'is_public'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function album()
    {
        return $this->belongsToMany('App\Album');
    }

    public function getFullNameAttribute()
    {
        return $this->imageName.'.'.$this->extension;
    }

    public function getRouteKeyName()
    {
        return 'pageName';
    }

    public function getFullPathAttribute()
    {
        return storage_path('app/public/images/'.$this->fullname);
    }

    public static function search($query)
    {
        // join('users', 'user_id', '=', 'users.id')
        // ->where('users.username', 'LIKE', '%'.$query.'%')
        return static::where('title', 'LIKE', '%'.$query.'%')
            ->orWhere('created_at', 'LIKE', '%'.$query.'%')
            ->orWhere('extension', 'LIKE', '%'.$query.'%')
            ->orWhere('pageName', 'LIKE', '%'.$query.'%')
            ->orWhere('imageName', 'LIKE', '%'.$query.'%')
            ->orWhere('is_public', 'LIKE', '%'.$query.'%');

        // ->select('users.*')
            // ->join('users', 'user_id', '=', 'users.id')
            // ->where('users.email', 'LIKE', '%'.$query.'%');
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
                ['title', 'LIKE', '%'.$query.'%'],
            ])
            ->orWhere([
                ['user_id', $user->id],
                ['created_at', 'LIKE', '%'.$query.'%'],
            ])
            ->orWhere([
                ['user_id', $user->id],
                ['extension', 'LIKE', '%'.$query.'%'],
            ])
            ->orWhere([
                ['user_id', $user->id],
                ['pageName', 'LIKE', '%'.$query.'%'],
            ])
            ->orWhere([
                ['user_id', $user->id],
                ['imageName', 'LIKE', '%'.$query.'%'],
            ])
            ->orWhere([
                ['user_id', $user->id],
                ['is_public', 'LIKE', '%'.$query.'%'],
            ]);
    }
}
