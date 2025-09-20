<?php

namespace Tests\Unit;

use App\Contracts\TaskRepositoryInterface;
use App\Models\Task;
use App\Services\TaskService;
use App\Strategies\TaskPriorityStrategy;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;
use Mockery;

/**
 * Test Service Layer Pattern and Dependency Injection
 */
class TaskServiceTest extends TestCase
{
    private TaskService $taskService;
    private TaskRepositoryInterface $mockRepository;
    private TaskPriorityStrategy $mockStrategy;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->mockRepository = Mockery::mock(TaskRepositoryInterface::class);
        $this->mockStrategy = Mockery::mock(TaskPriorityStrategy::class);
        
        $this->taskService = new TaskService(
            $this->mockRepository,
            $this->mockStrategy
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_all_tasks_delegates_to_repository(): void
    {
        $expectedTasks = new Collection([new Task()]);
        
        $this->mockRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($expectedTasks);

        $result = $this->taskService->getAllTasks();

        $this->assertSame($expectedTasks, $result);
    }

    public function test_create_task_with_auto_priority_calculation(): void
    {
        $taskData = [
            'title' => 'Test Task',
            'due_date' => '2025-09-25'
        ];

        $this->mockStrategy
            ->shouldReceive('calculatePriority')
            ->with('2025-09-25')
            ->once()
            ->andReturn('high');

        $expectedTask = new Task();
        $expectedData = array_merge($taskData, ['priority' => 'high']);

        $this->mockRepository
            ->shouldReceive('create')
            ->with($expectedData)
            ->once()
            ->andReturn($expectedTask);

        $result = $this->taskService->createTask($taskData);

        $this->assertSame($expectedTask, $result);
    }

    public function test_get_task_statistics_calculates_correctly(): void
    {
        $tasks = new Collection([
            (object)['status' => 'completed'],
            (object)['status' => 'pending'],
            (object)['status' => 'in_progress'],
            (object)['status' => 'completed'],
        ]);

        $this->mockRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($tasks);

        $this->mockRepository
            ->shouldReceive('getOverdueTasks')
            ->once()
            ->andReturn(new Collection([]));

        $this->mockRepository
            ->shouldReceive('getHighPriorityTasks')
            ->once()
            ->andReturn(new Collection([]));

        $stats = $this->taskService->getTaskStatistics();

        $this->assertEquals(4, $stats['total']);
        $this->assertEquals(2, $stats['completed']);
        $this->assertEquals(1, $stats['pending']);
        $this->assertEquals(1, $stats['in_progress']);
    }
}