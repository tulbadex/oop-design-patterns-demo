<?php

namespace App\Providers;

use App\Contracts\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use App\Strategies\TaskPriorityStrategy;
use Illuminate\Support\ServiceProvider;

/**
 * Task Service Provider - Demonstrating Dependency Injection Container
 */
class TaskServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind interface to implementation - Dependency Inversion Principle
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        
        // Register services as singletons
        $this->app->singleton(TaskService::class, function ($app) {
            return new TaskService(
                $app->make(TaskRepositoryInterface::class),
                $app->make(TaskPriorityStrategy::class)
            );
        });
        
        $this->app->singleton(TaskPriorityStrategy::class);
    }

    public function boot(): void
    {
        //
    }
}
