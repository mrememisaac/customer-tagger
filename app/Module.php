<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'course_key',
        'name'
    ];

    public function course(){
        return $this->belongsTo('App\Course', 'course_key');
    }
}
