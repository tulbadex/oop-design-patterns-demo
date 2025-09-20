<?php

namespace Tests\Unit;

use App\Strategies\TaskPriorityStrategy;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

/**
 * Test Strategy Pattern Implementation
 */
class TaskPriorityStrategyTest extends TestCase
{
    private TaskPriorityStrategy $strategy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->strategy = new TaskPriorityStrategy();
    }

    public function test_calculate_priority_for_overdue_task(): void
    {
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        
        $priority = $this->strategy->calculatePriority($yesterday);
        
        $this->assertEquals('high', $priority);
    }

    public function test_calculate_priority_for_today(): void
    {
        $today = Carbon::today()->format('Y-m-d');
        
        $priority = $this->strategy->calculatePriority($today);
        
        $this->assertEquals('high', $priority);
    }

    public function test_calculate_priority_for_tomorrow(): void
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        
        $priority = $this->strategy->calculatePriority($tomorrow);
        
        $this->assertEquals('high', $priority);
    }

    public function test_calculate_priority_for_next_week(): void
    {
        $nextWeek = Carbon::now()->addDays(5)->format('Y-m-d');
        
        $priority = $this->strategy->calculatePriority($nextWeek);
        
        $this->assertEquals('medium', $priority);
    }

    public function test_calculate_priority_for_far_future(): void
    {
        $farFuture = Carbon::now()->addDays(30)->format('Y-m-d');
        
        $priority = $this->strategy->calculatePriority($farFuture);
        
        $this->assertEquals('low', $priority);
    }

    public function test_get_priority_color_returns_correct_colors(): void
    {
        $this->assertEquals('#EF4444', $this->strategy->getPriorityColor('high'));
        $this->assertEquals('#F59E0B', $this->strategy->getPriorityColor('medium'));
        $this->assertEquals('#10B981', $this->strategy->getPriorityColor('low'));
        $this->assertEquals('#6B7280', $this->strategy->getPriorityColor('unknown'));
    }

    public function test_get_priority_weight_returns_correct_weights(): void
    {
        $this->assertEquals(3, $this->strategy->getPriorityWeight('high'));
        $this->assertEquals(2, $this->strategy->getPriorityWeight('medium'));
        $this->assertEquals(1, $this->strategy->getPriorityWeight('low'));
        $this->assertEquals(0, $this->strategy->getPriorityWeight('unknown'));
    }
}