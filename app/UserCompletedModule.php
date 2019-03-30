<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCompletedModule extends Model
{
    protected $fillable = [
        'user_id',
        'module_id'
    ];
}
