<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'color',
        'description'
    ];

    // Relationships
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // Business Logic - Factory Pattern for default categories
    public static function createDefault(): array
    {
        $defaults = [
            ['name' => 'Work', 'color' => '#3B82F6', 'description' => 'Work related tasks'],
            ['name' => 'Personal', 'color' => '#10B981', 'description' => 'Personal tasks'],
            ['name' => 'Urgent', 'color' => '#EF4444', 'description' => 'Urgent tasks'],
        ];

        $categories = [];
        foreach ($defaults as $default) {
            $categories[] = self::create($default);
        }

        return $categories;
    }

    public function getTasksCount(): int
    {
        return $this->tasks()->count();
    }
}
