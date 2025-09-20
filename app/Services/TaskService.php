<?php

namespace App\Services;

use App\Contracts\TaskRepositoryInterface;
use App\Models\Task;
use App\Strategies\TaskPriorityStrategy;
use Illuminate\Database\Eloquent\Collection;

/**
 * Task Service - Demonstrating Service Layer Pattern and Dependency Injection
 */
class TaskService
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TaskPriorityStrategy $priorityStrategy
    ) {}

    public function getAllTasks(): Collection
    {
        return $this->taskRepository->all();
    }

    public function createTask(array $data): Task
    {
        // Business logic: Auto-assign priority based on due date
        if (!isset($data['priority']) && isset($data['due_date'])) {
            $data['priority'] = $this->priorityStrategy->calculatePriority($data['due_date']);
        }

        return $this->taskRepository->create($data);
    }

    public function updateTask(int $id, array $data): bool
    {
        return $this->taskRepository->update($id, $data);
    }

    public function deleteTask(int $id): bool
    {
        return $this->taskRepository->delete($id);
    }

    public function getUserTasks(int $userId): Collection
    {
        return $this->taskRepository->getByUser($userId);
    }

    public function markTaskAsCompleted(int $taskId): bool
    {
        $task = $this->taskRepository->find($taskId);
        
        if ($task) {
            $task->markAsCompleted();
            return true;
        }
        
        return false;
    }

    public function getTaskStatistics(): array
    {
        $allTasks = $this->taskRepository->all();
        
        return [
            'total' => $allTasks->count(),
            'completed' => $allTasks->where('status', 'completed')->count(),
            'pending' => $allTasks->where('status', 'pending')->count(),
            'in_progress' => $allTasks->where('status', 'in_progress')->count(),
            'overdue' => $this->taskRepository->getOverdueTasks()->count(),
            'high_priority' => $this->taskRepository->getHighPriorityTasks()->count(),
        ];
    }

    public function getOverdueTasks(): Collection
    {
        return $this->taskRepository->getOverdueTasks();
    }
}