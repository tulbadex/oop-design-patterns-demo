@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Tasks</h1>
    <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create New Task</a>
</div>

<div class="bg-white shadow-md rounded-lg p-6">
    @forelse($tasks as $task)
        <div class="task-item flex items-center justify-between py-4 border-b last:border-b-0">
            <div class="flex items-center space-x-4">
                <input type="checkbox" 
                       class="task-checkbox" 
                       data-task-id="{{ $task->id }}"
                       {{ $task->status === 'completed' ? 'checked' : '' }}>
                <div class="{{ $task->status === 'completed' ? 'opacity-50 line-through' : '' }}">
                    <h3 class="font-semibold">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $task->description }}</p>
                    <div class="flex items-center space-x-2 mt-1">
                        <span class="px-2 py-1 text-xs rounded-full" 
                              style="background-color: {{ $task->category->color }}20; color: {{ $task->category->color }}">
                            {{ $task->category->name }}
                        </span>
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($task->priority === 'high') bg-red-100 text-red-800
                            @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($task->priority) }}
                        </span>
                        @if($task->due_date)
                            <span class="text-xs text-gray-500">
                                Due: {{ $task->due_date->format('M d, Y') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                @if($task->status !== 'completed')
                    <form action="{{ route('tasks.complete', $task) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-green-600 hover:text-green-800">Complete</button>
                    </form>
                @endif
                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800" 
                            onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-8">
            <p class="text-gray-500">No tasks found.</p>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4 inline-block">Create Your First Task</a>
        </div>
    @endforelse
</div>
@endsection