<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body'
    ];
}
