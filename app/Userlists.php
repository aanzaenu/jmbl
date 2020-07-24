<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userlists extends Model
{
    protected $table = 'users';

    public function usergroup()
    {
        return $this->hasOne(Group::class);
    }
}
