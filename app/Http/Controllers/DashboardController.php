<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $user  = auth()->user();

        if ($user->role == 'admin') {
            $stats = [
                'totalTasks' => Task::count(),
                'pendingTasks' => Task::where('status', 'pending')->count(),
                'inProgressTasks' => Task::where('status', 'in_progress')->count(),
                'completedTasks' => Task::where('status', 'completed')->count(),
                'overdueTasks' => Task::whereDate('due_date', '<', $today)
                    ->where('status', '!=', 'completed')
                    ->count(),
                'totalUsers' => User::count(),
            ];
            $upcomingTasks = Task::with('user')
                ->whereNotNull('due_date')
                ->whereDate('due_date', '>=', $today)
                ->where('status', '!=', 'completed')
                ->orderBy('due_date')
                ->limit(5)
                ->get();
        } else {
            $stats = [
                'totalTasks' => Task::where('user_id', $user->id)->count(),
                'pendingTasks' => Task::where('status', 'pending')->where('user_id', $user->id)->count(),
                'inProgressTasks' => Task::where('status', 'in_progress')->count(),
                'completedTasks' => Task::where('status', 'completed')->where('user_id', $user->id)->count(),
                'overdueTasks' => Task::whereDate('due_date', '<', $today)
                    ->where('status', '!=', 'completed')
                    ->where('user_id', $user->id)
                    ->count(),
                'totalUsers' => User::count(),
            ];
            $upcomingTasks = Task::with('user')
                ->whereNotNull('due_date')
                ->whereDate('due_date', '>=', $today)
                ->where('status', '!=', 'completed')
                ->where('user_id', $user->id)
                ->orderBy('due_date')
                ->limit(5)
                ->get();
        }



        return view('dashboard', compact('stats', 'upcomingTasks'));
    }
}
