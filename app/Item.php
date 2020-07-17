<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    const STATUSES = [
        'WAITING' => 0,
        'DOWNLOADED' => 1,
        'ERROR' => 2
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'status',
    ];

    protected $casts = [
        'content' => 'array'
    ];
}
