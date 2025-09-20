<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test Controller Layer and Integration
 */
class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data
        User::factory()->create(['id' => 1]);
        Category::factory()->create(['id' => 1, 'name' => 'Test Category']);
    }

    public function test_index_displays_tasks(): void
    {
        Task::factory()->count(3)->create();

        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
        $response->assertViewHas('tasks');
    }

    public function test_create_displays_form(): void
    {
        $response = $this->get(route('tasks.create'));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.create');
        $response->assertViewHas('categories');
    }

    public function test_store_creates_new_task(): void
    {
        $taskData = [
            'title' => 'New Task',
            'description' => 'Task description',
            'priority' => 'medium',
            'status' => 'pending',
            'category_id' => 1,
            'due_date' => '2025-12-31',
        ];

        $response = $this->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->post(route('tasks.store'), []);

        $response->assertSessionHasErrors(['title', 'priority', 'status', 'category_id']);
    }

    public function test_update_modifies_existing_task(): void
    {
        $task = Task::factory()->create(['title' => 'Original Title']);

        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'priority' => 'high',
            'status' => 'in_progress',
            'category_id' => 1,
        ];

        $response = $this->put(route('tasks.update', $task), $updateData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Title']);
    }

    public function test_destroy_deletes_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_complete_marks_task_as_completed(): void
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $response = $this->patch(route('tasks.complete', $task));

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
    }

    public function test_dashboard_displays_statistics(): void
    {
        Task::factory()->count(5)->create();

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewHas(['statistics', 'overdueTasks', 'recentTasks']);
    }
}