<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=[
        'title',
        'content',
        'user_id'
    ];

    public function users(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function comments(){
        return $this->hasMany('App\Comment','post_id','id');
    }
}
