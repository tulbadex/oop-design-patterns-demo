<?php

namespace App\Strategies;

use Carbon\Carbon;

/**
 * Task Priority Strategy - Demonstrating Strategy Pattern
 */
class TaskPriorityStrategy
{
    public function calculatePriority(string $dueDate): string
    {
        $due = Carbon::parse($dueDate);
        $now = Carbon::now();
        $daysUntilDue = $now->diffInDays($due, false);

        return match (true) {
            $daysUntilDue < 0 => 'high',        // Overdue
            $daysUntilDue <= 1 => 'high',       // Due today or tomorrow
            $daysUntilDue <= 7 => 'medium',     // Due within a week
            default => 'low'                     // Due later
        };
    }

    public function getPriorityColor(string $priority): string
    {
        return match ($priority) {
            'high' => '#EF4444',    // Red
            'medium' => '#F59E0B',  // Yellow
            'low' => '#10B981',     // Green
            default => '#6B7280'    // Gray
        };
    }

    public function getPriorityWeight(string $priority): int
    {
        return match ($priority) {
            'high' => 3,
            'medium' => 2,
            'low' => 1,
            default => 0
        };
    }
}