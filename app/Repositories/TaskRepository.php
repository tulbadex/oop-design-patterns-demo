<?php

namespace App\Repositories;

use App\Contracts\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

/**
 * Task Repository Implementation - Demonstrating Repository Pattern
 */
class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(
        private Task $model
    ) {}

    public function all(): Collection
    {
        return $this->model->with(['user', 'category'])->get();
    }

    public function find(int $id): ?Task
    {
        return $this->model->with(['user', 'category'])->find($id);
    }

    public function create(array $data): Task
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $task = $this->find($id);
        return $task ? $task->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $task = $this->find($id);
        return $task ? $task->delete() : false;
    }

    public function getByUser(int $userId): Collection
    {
        return $this->model->where('user_id', $userId)
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByCategory(int $categoryId): Collection
    {
        return $this->model->where('category_id', $categoryId)
            ->with(['user'])
            ->get();
    }

    public function getOverdueTasks(): Collection
    {
        return $this->model->where('due_date', '<', now())
            ->where('status', '!=', 'completed')
            ->with(['user', 'category'])
            ->get();
    }

    public function getHighPriorityTasks(): Collection
    {
        return $this->model->highPriority()
            ->with(['user', 'category'])
            ->get();
    }
}