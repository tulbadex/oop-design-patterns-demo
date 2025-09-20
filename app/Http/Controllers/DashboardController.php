<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\View\View;

/**
 * Dashboard Controller - Demonstrating Service Layer Usage
 */
class DashboardController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    public function index(): View
    {
        $statistics = $this->taskService->getTaskStatistics();
        $overdueTasks = $this->taskService->getOverdueTasks();
        $recentTasks = $this->taskService->getAllTasks()->take(5);
        
        return view('dashboard', compact('statistics', 'overdueTasks', 'recentTasks'));
    }
}
