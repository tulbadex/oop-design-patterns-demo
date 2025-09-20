import './bootstrap';
import '../css/app.css';

// Simple task management functionality
document.addEventListener('DOMContentLoaded', function() {
    // Task completion toggle
    const taskCheckboxes = document.querySelectorAll('.task-checkbox');
    taskCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const taskId = this.dataset.taskId;
            const isCompleted = this.checked;
            
            // Add visual feedback
            const taskRow = this.closest('.task-item');
            if (isCompleted) {
                taskRow.classList.add('opacity-50', 'line-through');
            } else {
                taskRow.classList.remove('opacity-50', 'line-through');
            }
        });
    });
    
    // Form validation and button states
    const taskForm = document.getElementById('task-form');
    if (taskForm) {
        const submitBtn = document.getElementById('submit-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        
        taskForm.addEventListener('submit', function(e) {
            const title = document.getElementById('title');
            if (!title.value.trim()) {
                e.preventDefault();
                alert('Task title is required');
                title.focus();
                return;
            }
            
            // Disable buttons during submission
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Creating...';
            }
            if (cancelBtn) {
                cancelBtn.style.pointerEvents = 'none';
                cancelBtn.classList.add('opacity-50');
            }
        });
    }
});