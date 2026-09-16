<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    protected $fillable = [
        'uuid',
        'title',
        'user_id',
        'description',
        'due_date',
        'estimated_time',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function user(){
        return $this->belongsTo(User::class );
    }
}
