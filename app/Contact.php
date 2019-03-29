<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'Id',
        'id',
        'Email',
        'Tag',
        '_Products'
    ];
}
