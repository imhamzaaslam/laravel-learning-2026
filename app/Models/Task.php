<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // protected $fillable = [
    //     'uuid',
    //     'title',
    //     'description',
    //     'due_date',
    //     'estimated_time',
    // ];

    protected $casts = [
        'due_date' => 'date',
    ];
}
