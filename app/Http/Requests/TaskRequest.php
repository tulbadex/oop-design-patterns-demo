<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Task Request - Demonstrating Validation Encapsulation
 */
class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow for demo purposes
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date|after_or_equal:today',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Task title is required.',
            'due_date.after_or_equal' => 'Due date cannot be in the past.',
            'category_id.exists' => 'Selected category does not exist.',
        ];
    }
}
