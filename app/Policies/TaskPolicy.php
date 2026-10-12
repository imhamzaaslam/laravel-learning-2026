<?php

namespace App\Policies;

use App\Models\User;

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    //create can see policy for admin and user
    public function view(User $user, $task)
    {
        return $user->role === 'admin' || $user->id === $task->user_id;
    }

    public function list(User $user)
    {
        return $user->role === 'admin';
    }
}
