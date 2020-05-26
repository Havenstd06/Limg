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
}
