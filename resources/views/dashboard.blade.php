@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-700">Total Tasks</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $statistics['total'] }}</p>
    </div>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-700">Completed</h3>
        <p class="text-3xl font-bold text-green-600">{{ $statistics['completed'] }}</p>
    </div>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-700">Pending</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ $statistics['pending'] }}</p>
    </div>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-700">Overdue</h3>
        <p class="text-3xl font-bold text-red-600">{{ $statistics['overdue'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Recent Tasks</h3>
        @forelse($recentTasks as $task)
            <div class="flex items-center justify-between py-2 border-b last:border-b-0">
                <div>
                    <p class="font-medium">{{ $task->title }}</p>
                    <p class="text-sm text-gray-500">{{ $task->category->name }}</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($task->priority === 'high') bg-red-100 text-red-800
                    @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                    @else bg-green-100 text-green-800 @endif">
                    {{ ucfirst($task->priority) }}
                </span>
            </div>
        @empty
            <p class="text-gray-500">No tasks yet.</p>
        @endforelse
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Overdue Tasks</h3>
        @forelse($overdueTasks as $task)
            <div class="flex items-center justify-between py-2 border-b last:border-b-0">
                <div>
                    <p class="font-medium text-red-600">{{ $task->title }}</p>
                    <p class="text-sm text-gray-500">Due: {{ $task->due_date->format('M d, Y') }}</p>
                </div>
                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
            </div>
        @empty
            <p class="text-gray-500">No overdue tasks.</p>
        @endforelse
    </div>
</div>
@endsection