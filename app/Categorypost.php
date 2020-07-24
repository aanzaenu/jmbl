<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorypost extends Model
{
    protected $guarded = ['id'];
    
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
