# Design Patterns Showcase - Task Management System

A Laravel-based Task Management System demonstrating **Object-Oriented Programming (OOP) patterns** and **clean architecture principles**.

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)

## 🎯 OOP Patterns Demonstrated

### 1. **Repository Pattern**
- **Interface**: `TaskRepositoryInterface` - Defines contract for data access
- **Implementation**: `TaskRepository` - Concrete implementation with database operations
- **Benefits**: Decouples business logic from data access, enables easy testing

```php
interface TaskRepositoryInterface {
    public function all(): Collection;
    public function find(int $id): ?Task;
    public function create(array $data): Task;
}

class TaskRepository implements TaskRepositoryInterface {
    // Implementation with Eloquent
}
```

### 2. **Service Layer Pattern**
- **Class**: `TaskService` - Encapsulates business logic
- **Benefits**: Separates business rules from controllers, promotes reusability

```php
class TaskService {
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TaskPriorityStrategy $priorityStrategy
    ) {}
    
    public function createTask(array $data): Task {
        // Business logic here
    }
}
```

### 3. **Strategy Pattern**
- **Class**: `TaskPriorityStrategy` - Encapsulates priority calculation algorithms
- **Benefits**: Makes algorithms interchangeable, follows Open/Closed Principle

```php
class TaskPriorityStrategy {
    public function calculatePriority(string $dueDate): string {
        // Algorithm for priority calculation
    }
}
```

### 4. **Observer Pattern**
- **Class**: `TaskObserver` - Responds to model lifecycle events
- **Benefits**: Decouples event handling, enables logging and notifications

```php
class TaskObserver {
    public function created(Task $task): void {
        Log::info("New task created: {$task->title}");
    }
}
```

### 5. **Dependency Injection**
- **Service Provider**: `TaskServiceProvider` - Binds interfaces to implementations
- **Benefits**: Promotes loose coupling, enables easy testing and swapping implementations

```php
class TaskServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }
}
```

### 6. **Factory Pattern**
- **Method**: `Category::createDefault()` - Creates default categories
- **Benefits**: Encapsulates object creation logic

### 7. **Form Request Pattern**
- **Class**: `TaskRequest` - Encapsulates validation rules
- **Benefits**: Separates validation logic from controllers

## 🏗️ Architecture Overview

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Controllers   │───▶│    Services     │───▶│  Repositories   │
│                 │    │                 │    │                 │
│ - TaskController│    │ - TaskService   │    │ - TaskRepository│
│ - Dashboard     │    │                 │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Requests      │    │   Strategies    │    │     Models      │
│                 │    │                 │    │                 │
│ - TaskRequest   │    │ - PriorityCalc  │    │ - Task          │
│                 │    │                 │    │ - Category      │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

## 🚀 Features

- **Task CRUD Operations** - Create, read, update, delete tasks
- **Priority Management** - Automatic priority calculation based on due dates
- **Category System** - Organize tasks by categories
- **Dashboard Analytics** - Task statistics and overdue tracking
- **Responsive UI** - Built with Tailwind CSS and Vite

## 📦 Installation

```bash
# Clone repository
git clone https://github.com/tulbadex/oop-design-patterns-demo.git
cd oop-design-patterns-demo

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CategorySeeder

# Build assets (run in separate terminal)
npm run dev

# Start server (run in separate terminal)
php artisan serve
```

## 🎮 Quick Demo

1. **Access Application**: Visit `http://localhost:8000`
2. **View Dashboard**: See task statistics and overview
3. **Create Tasks**: Click "New Task" to add tasks with categories
4. **Manage Tasks**: Edit, complete, or delete tasks
5. **Demo User**: Uses `demo@example.com` (no authentication required for demo)

## 📊 Sample Data

**Default Categories:**
- 🔵 Work (Blue) - Work related tasks
- 🟢 Personal (Green) - Personal tasks  
- 🔴 Urgent (Red) - Urgent tasks

**Demo User:**
- Name: Demo User
- Email: demo@example.com

## 🏗️ Complete Project Structure

```
app/
├── Models/
│   ├── Task.php (relationships & business logic)
│   ├── Category.php (factory methods)
│   └── User.php
├── Http/
│   ├── Controllers/
│   │   ├── TaskController.php (resource controller)
│   │   └── DashboardController.php
│   └── Requests/
│       └── TaskRequest.php (validation encapsulation)
├── Services/
│   └── TaskService.php (business logic layer)
├── Repositories/
│   └── TaskRepository.php (data access layer)
├── Contracts/
│   └── TaskRepositoryInterface.php
├── Observers/
│   └── TaskObserver.php (event handling)
├── Strategies/
│   └── TaskPriorityStrategy.php (algorithms)
└── Providers/
    └── TaskServiceProvider.php (DI binding)

database/
├── migrations/ (task & category tables)
└── seeders/
    ├── UserSeeder.php (demo user)
    └── CategorySeeder.php (default categories)
```

## 🔧 Key Classes & Their Responsibilities

| Class | Pattern | Responsibility |
|-------|---------|----------------|
| `TaskController` | MVC | HTTP request handling, delegates to service |
| `TaskService` | Service Layer | Business logic, orchestrates operations |
| `TaskRepository` | Repository | Data access abstraction |
| `TaskRepositoryInterface` | Interface | Contract for repository implementations |
| `TaskPriorityStrategy` | Strategy | Priority calculation algorithms |
| `TaskObserver` | Observer | Event handling and logging |
| `TaskRequest` | Form Request | Input validation and sanitization |
| `TaskServiceProvider` | Service Provider | Dependency injection binding |
| `UserSeeder` | Seeder | Creates demo user data |
| `CategorySeeder` | Seeder | Creates default categories |

## 🎨 Design Principles Applied

- **Single Responsibility Principle** - Each class has one reason to change
- **Open/Closed Principle** - Open for extension, closed for modification
- **Liskov Substitution Principle** - Interfaces can be substituted
- **Interface Segregation Principle** - Focused, specific interfaces
- **Dependency Inversion Principle** - Depend on abstractions, not concretions

## 🧪 Comprehensive Testing

### Test Coverage
- **Unit Tests**: 17 tests covering all OOP patterns
- **Feature Tests**: Integration testing for controllers
- **Strategy Pattern Tests**: Algorithm validation
- **Repository Pattern Tests**: Data access layer testing
- **Service Layer Tests**: Business logic validation

### Running Tests
```bash
# Run all tests
php artisan test

# Run only unit tests
php artisan test --testsuite=Unit

# Run with coverage
php artisan test --coverage
```

### Test Structure
```
tests/
├── Unit/
│   ├── TaskServiceTest.php (Service Layer)
│   ├── TaskRepositoryTest.php (Repository Pattern)
│   └── TaskPriorityStrategyTest.php (Strategy Pattern)
└── Feature/
    └── TaskControllerTest.php (Integration Tests)
```

### What's Tested
- ✅ **Dependency Injection** - Mock services and repositories
- ✅ **Interface Contracts** - Test against interfaces
- ✅ **Service Layer** - Unit test business logic in isolation
- ✅ **Repository Pattern** - Data access abstraction
- ✅ **Strategy Pattern** - Algorithm implementations
- ✅ **Controller Integration** - HTTP request/response flow
- ✅ **Model Factories** - Test data generation
- ✅ **Database Relationships** - Foreign key constraints

## 📱 Usage

1. **Dashboard** - View task statistics and overdue items
2. **Create Tasks** - Add new tasks with categories and priorities
3. **Manage Tasks** - Edit, complete, or delete existing tasks
4. **Auto-Priority** - System calculates priority based on due dates

## ✅ Test Results

**All 17 Unit Tests Pass:**
- TaskServiceTest: 3/3 ✅
- TaskRepositoryTest: 6/6 ✅  
- TaskPriorityStrategyTest: 7/7 ✅
- ExampleTest: 1/1 ✅

**Test Coverage Includes:**
- Repository Pattern implementation
- Service Layer business logic
- Strategy Pattern algorithms
- Dependency Injection containers
- Model relationships and factories

## 🔍 Code Quality Features

- **Type Declarations** - Full PHP 8+ type hints
- **Constructor Property Promotion** - Modern PHP syntax
- **Enum Usage** - For status and priority values
- **Eloquent Relationships** - Proper ORM usage
- **Validation** - Comprehensive input validation
- **Error Handling** - Graceful error management
- **Interactive UI** - Form validation and button states
- **Responsive Design** - Tailwind CSS styling

## 🛠️ Troubleshooting

**Database Issues:**
```bash
# Reset database
php artisan migrate:fresh
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CategorySeeder
```

**Asset Issues:**
```bash
# Clear and rebuild
npm run build
php artisan optimize:clear
```

**Foreign Key Errors:**
- Ensure UserSeeder runs before creating tasks
- Demo user (ID: 1) must exist

## 📝 Project Highlights

✅ **Clean Architecture** - Layered design with clear separation
✅ **SOLID Principles** - Applied throughout the codebase
✅ **Design Patterns** - 7+ patterns demonstrated
✅ **Modern PHP** - PHP 8+ features and syntax
✅ **Interactive UI** - Real-time form validation
✅ **Database Design** - Proper relationships and constraints
✅ **Error Handling** - Comprehensive validation and logging

---

**Built to demonstrate clean, maintainable, and testable PHP/Laravel code using proven OOP design patterns.**