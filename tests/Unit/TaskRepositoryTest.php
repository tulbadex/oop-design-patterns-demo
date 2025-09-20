<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test Repository Pattern Implementation
 */
class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private TaskRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new TaskRepository(new Task());
    }

    public function test_create_task_stores_in_database(): void
    {
        $user = \App\Models\User::factory()->create();
        $category = \App\Models\Category::factory()->create();
        
        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'priority' => 'medium',
            'status' => 'pending',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ];

        $task = $this->repository->create($taskData);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals('Test Task', $task->title);
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function test_find_returns_task_with_relationships(): void
    {
        $task = Task::factory()->create();
        
        $foundTask = $this->repository->find($task->id);
        
        $this->assertInstanceOf(Task::class, $foundTask);
        $this->assertEquals($task->id, $foundTask->id);
    }

    public function test_update_modifies_existing_task(): void
    {
        $task = Task::factory()->create(['title' => 'Original Title']);
        
        $updated = $this->repository->update($task->id, ['title' => 'Updated Title']);
        
        $this->assertTrue($updated);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Title']);
    }

    public function test_delete_removes_task_from_database(): void
    {
        $task = Task::factory()->create();
        
        $deleted = $this->repository->delete($task->id);
        
        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_get_by_user_filters_correctly(): void
    {
        $user1 = \App\Models\User::factory()->create();
        $user2 = \App\Models\User::factory()->create();
        
        $user1Tasks = Task::factory()->count(2)->create(['user_id' => $user1->id]);
        Task::factory()->create(['user_id' => $user2->id]);
        
        $userTasks = $this->repository->getByUser($user1->id);
        
        $this->assertCount(2, $userTasks);
        $this->assertTrue($userTasks->every(fn($task) => $task->user_id === $user1->id));
    }

    public function test_get_high_priority_tasks_filters_correctly(): void
    {
        Task::factory()->create(['priority' => 'high']);
        Task::factory()->create(['priority' => 'medium']);
        Task::factory()->create(['priority' => 'high']);
        
        $highPriorityTasks = $this->repository->getHighPriorityTasks();
        
        $this->assertCount(2, $highPriorityTasks);
        $this->assertTrue($highPriorityTasks->every(fn($task) => $task->priority === 'high'));
    }
}