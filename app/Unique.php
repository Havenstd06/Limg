<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unique extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['title'];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getFullNameAttribute()
    {
        return $this->name.'.'.$this->extension;
    }

    public function getFullPathAttribute()
    {
        return storage_path('app/public/uniques/'.$this->fullname);
    }

    public function getShareLinkAttribute()
    {
        return route('unique.show', ['unique' => $this->shareName]);
    }
}
