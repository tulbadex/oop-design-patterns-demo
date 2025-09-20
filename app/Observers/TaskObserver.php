<?php

namespace App\Observers;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

/**
 * Task Observer - Demonstrating Observer Pattern
 */
class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        Log::info("New task created: {$task->title}", [
            'task_id' => $task->id,
            'user_id' => $task->user_id,
            'priority' => $task->priority
        ]);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        // Check if status changed to completed
        if ($task->isDirty('status') && $task->status === 'completed') {
            Log::info("Task completed: {$task->title}", [
                'task_id' => $task->id,
                'completed_at' => now()
            ]);
        }

        // Check if priority changed
        if ($task->isDirty('priority')) {
            Log::info("Task priority changed: {$task->title}", [
                'task_id' => $task->id,
                'old_priority' => $task->getOriginal('priority'),
                'new_priority' => $task->priority
            ]);
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        Log::info("Task deleted: {$task->title}", [
            'task_id' => $task->id,
            'deleted_at' => now()
        ]);
    }
}