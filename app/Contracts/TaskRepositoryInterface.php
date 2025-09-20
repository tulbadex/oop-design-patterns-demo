<?php

namespace App\Contracts;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

/**
 * Task Repository Interface - Demonstrating Interface Segregation Principle
 */
interface TaskRepositoryInterface
{
    public function all(): Collection;
    
    public function find(int $id): ?Task;
    
    public function create(array $data): Task;
    
    public function update(int $id, array $data): bool;
    
    public function delete(int $id): bool;
    
    public function getByUser(int $userId): Collection;
    
    public function getByCategory(int $categoryId): Collection;
    
    public function getOverdueTasks(): Collection;
    
    public function getHighPriorityTasks(): Collection;
}