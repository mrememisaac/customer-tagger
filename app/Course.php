<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'id',
        'course_key',
    ];

    public function modules(){
        return $this->hasMany('App\Comment', 'course_key', 'course_key');
    }
}

