<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Category;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Task Controller - Demonstrating Dependency Injection and Clean Architecture
 */
class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    public function index(): View
    {
        $tasks = $this->taskService->getAllTasks();
        return view('tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id() ?? 1; // Default user for demo
        
        $this->taskService->createTask($data);
        
        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    public function show(int $id): View
    {
        $task = $this->taskService->getAllTasks()->find($id);
        return view('tasks.show', compact('task'));
    }

    public function edit(int $id): View
    {
        $task = $this->taskService->getAllTasks()->find($id);
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(TaskRequest $request, int $id): RedirectResponse
    {
        $this->taskService->updateTask($id, $request->validated());
        
        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->taskService->deleteTask($id);
        
        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }

    public function complete(int $id): RedirectResponse
    {
        $this->taskService->markTaskAsCompleted($id);
        
        return redirect()->back()
            ->with('success', 'Task marked as completed!');
    }
}
