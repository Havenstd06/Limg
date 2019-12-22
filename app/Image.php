<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getFullNameAttribute() 
    {
        return $this->name . '.' . $this->extension;
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
    
}
