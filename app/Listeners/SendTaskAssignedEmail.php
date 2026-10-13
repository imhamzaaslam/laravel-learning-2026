<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Mail\TaskAssignedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendTaskAssignedEmail implements ShouldQueue
{
    public function handle(TaskCreated $event): void
    {
        $task = $event->task;

        if (! $task->user) {
            return;
        }

        Mail::to($task->user->email)->send(new TaskAssignedMail($task));
        
    }
}
