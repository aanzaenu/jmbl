<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }
    public function categories()
    {
        return $this->hasOne(Category::class);
    }
    public function categoryposts()
    {
        return $this->hasOne(Categorypost::class);
    }
    public static function cari($query, $pagination)
    {
        return DB::table('posts')->paginate(10);
    }
}
