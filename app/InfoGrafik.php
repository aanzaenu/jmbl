<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoGrafik extends Model
{
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }
}
