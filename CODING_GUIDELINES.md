# Coding Guidelines - Job Board Application

This document outlines the coding standards and best practices for the Job Board Laravel Livewire application. These guidelines ensure consistency, maintainability, and quality across the codebase.

## Table of Contents

1. [General Principles](#general-principles)
2. [PHP Standards](#php-standards)
3. [Laravel Framework Guidelines](#laravel-framework-guidelines)
4. [Livewire Components](#livewire-components)
5. [Frontend Guidelines](#frontend-guidelines)
6. [Database & Models](#database--models)
7. [Testing Standards](#testing-standards)
8. [Security Guidelines](#security-guidelines)
9. [Performance Best Practices](#performance-best-practices)
10. [Code Review Checklist](#code-review-checklist)

## General Principles

### Code Quality
- Write clean, readable, and self-documenting code
- Follow SOLID principles and DRY (Don't Repeat Yourself)
- Use descriptive names for variables, methods, and classes
- Keep methods focused on a single responsibility
- Prefer composition over inheritance where appropriate

### Documentation
- Document complex business logic with inline comments
- Use PHPDoc blocks for all public methods
- Keep README.md and documentation up to date
- Document API endpoints and their expected parameters

## PHP Standards

### Version
- **PHP 8.3.16** - Use modern PHP features and syntax

### Code Style
- Follow PSR-12 coding standards
- Use Laravel Pint for code formatting: `vendor/bin/pint --dirty`
- Always run Pint before committing changes

### Type Declarations
```php
// ✅ Good: Explicit return types and parameter types
protected function isAccessible(User $user, ?string $path = null): bool
{
    return $user->hasPermission($path);
}

// ❌ Bad: No type declarations
protected function isAccessible($user, $path = null)
{
    return $user->hasPermission($path);
}
```

### Constructor Property Promotion
```php
// ✅ Good: Use PHP 8 constructor property promotion
public function __construct(
    public GitHub $github,
    public UserService $userService
) {}

// ❌ Bad: Traditional constructor
public function __construct(GitHub $github, UserService $userService)
{
    $this->github = $github;
    $this->userService = $userService;
}
```

### Control Structures
```php
// ✅ Good: Always use curly braces
if ($condition) {
    $this->performAction();
}

// ❌ Bad: Single line without braces
if ($condition) $this->performAction();
```

### Enums
```php
// ✅ Good: TitleCase enum values
enum JobStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Pending = 'pending';
}
```

## Laravel Framework Guidelines

### Laravel 12 Structure
- Follow the streamlined Laravel 12 file structure
- Register middleware in `bootstrap/app.php`
- Use `bootstrap/providers.php` for service providers
- Commands auto-register from `app/Console/Commands/`

### Artisan Commands
```bash
# Use artisan make commands for file generation
php artisan make:controller JobController --resource --no-interaction
php artisan make:model Job --factory --seeder --migration --no-interaction
php artisan make:livewire JobCreate --no-interaction
```

### Database & Eloquent
```php
// ✅ Good: Use Eloquent relationships with return types
public function applications(): HasMany
{
    return $this->hasMany(JobApplication::class);
}

// ✅ Good: Use eager loading to prevent N+1 queries
$jobs = Job::with('applications')->latest()->get();

// ✅ Good: Use Model::query() instead of DB::
$jobs = Job::query()
    ->where('status', 'active')
    ->latest()
    ->get();
```

### Validation
```php
// ✅ Good: Use Form Request classes
php artisan make:request StoreJobRequest --no-interaction

// In the Form Request:
public function rules(): array
{
    return [
        'title' => 'required|string|max:255',
        'company' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'description' => 'required|string',
    ];
}
```

### Configuration
```php
// ✅ Good: Use config() helper
$appName = config('app.name');

// ❌ Bad: Direct env() usage outside config files
$appName = env('APP_NAME');
```

### URL Generation
```php
// ✅ Good: Use named routes
return redirect()->route('jobs.index');

// ✅ Good: Generate URLs with route helper
$url = route('jobs.show', $job);
```

## Livewire Components

### Component Structure
```php
<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Component;
use Livewire\Attributes\Validate;

class JobCreate extends Component
{
    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:255')]
    public string $company = '';

    #[Validate('required|string|max:255')]
    public string $location = '';

    #[Validate('required|string')]
    public string $description = '';

    public function save(): void
    {
        $this->authorize('create', Job::class);
        
        $this->validate();

        $job = Job::create([
            'title' => $this->title,
            'company' => $this->company,
            'location' => $this->location,
            'description' => $this->description,
        ]);

        $this->dispatch('jobCreated', $job->id);
        $this->reset();
        
        session()->flash('success', 'Job created successfully!');
    }

    public function render(): View
    {
        return view('livewire.job-create');
    }
}
```

### Livewire Best Practices

#### Property Initialization
```php
// ✅ Good: Initialize properties with default values
public string $search = '';
public array $filters = [];
public bool $isLoading = false;
```

#### Lifecycle Hooks
```php
public function mount(Job $job): void
{
    $this->job = $job;
    $this->title = $job->title;
}

public function updatedSearch(): void
{
    $this->resetPage();
}
```

#### Event Handling
```php
// ✅ Good: Use dispatch() for events
$this->dispatch('jobCreated', $job->id);

// ✅ Good: Listen for events in JavaScript
document.addEventListener('livewire:init', function () {
    Livewire.on('jobCreated', (jobId) => {
        // Handle the event
    });
});
```

#### Authorization
```php
// ✅ Good: Always check authorization in Livewire actions
public function delete(): void
{
    $this->authorize('delete', $this->job);
    
    $this->job->delete();
    $this->dispatch('jobDeleted');
}
```

### Blade Templates

#### Component Root Element
```blade
{{-- ✅ Good: Single root element --}}
<div class="job-create-form">
    <form wire:submit.prevent="save">
        <!-- Form content -->
    </form>
</div>
```

#### Wire Directives
```blade
{{-- ✅ Good: Use wire:model.live for real-time updates --}}
<input type="text" wire:model.live="search" placeholder="Search jobs...">

{{-- ✅ Good: Use wire:key in loops --}}
@foreach ($jobs as $job)
    <div wire:key="job-{{ $job->id }}">
        {{ $job->title }}
    </div>
@endforeach

{{-- ✅ Good: Loading states --}}
<button wire:click="save" wire:loading.attr="disabled" wire:target="save">
    <span wire:loading.remove wire:target="save">Save Job</span>
    <span wire:loading wire:target="save">Saving...</span>
</button>
```

## Frontend Guidelines

### Tailwind CSS v4
```css
/* ✅ Good: Use v4 import syntax */
@import "tailwindcss";

/* ❌ Bad: v3 syntax */
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### Utility Classes
```blade
{{-- ✅ Good: Use gap for spacing in flex/grid --}}
<div class="flex gap-4">
    <div>Item 1</div>
    <div>Item 2</div>
</div>

{{-- ✅ Good: Use updated utility names --}}
<div class="text-black/50 bg-white/90 shrink-0">
    Content
</div>

{{-- ❌ Bad: Deprecated utilities --}}
<div class="text-opacity-50 bg-opacity-90 flex-shrink-0">
    Content
</div>
```

### Dark Mode Support
```blade
{{-- ✅ Good: Support dark mode --}}
<div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
    Content
</div>
```

### Alpine.js Integration
```blade
{{-- ✅ Good: Alpine.js with Livewire --}}
<div x-data="{ open: false }">
    <button @click="open = !open" class="btn">
        Toggle
    </button>
    <div x-show="open" x-transition>
        Content
    </div>
</div>
```

## Database & Models

### Model Structure
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_lists';

    protected $fillable = [
        'title',
        'company',
        'location',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
```

### Migration Guidelines
```php
// ✅ Good: Include all column attributes when modifying
Schema::table('jobs', function (Blueprint $table) {
    $table->string('title', 255)->nullable(false)->change();
    $table->text('description')->nullable(false)->change();
});

// ✅ Good: Use descriptive migration names
php artisan make:migration add_status_column_to_jobs_table --no-interaction
```

### Factory Usage
```php
// ✅ Good: Use factories in tests
$job = Job::factory()->create([
    'title' => 'Software Developer',
    'company' => 'Tech Corp',
]);

// ✅ Good: Create factory states
Job::factory()->active()->create();
```

## Testing Standards

### Test Structure
```php
<?php

namespace Tests\Feature\Livewire;

use App\Livewire\JobCreate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class JobCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_admin_can_create_job(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        Livewire::test(JobCreate::class)
            ->set('title', 'Software Developer')
            ->set('company', 'Tech Corp')
            ->set('location', 'Remote')
            ->set('description', 'Great opportunity')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('jobCreated');

        $this->assertDatabaseHas('job_lists', [
            'title' => 'Software Developer',
            'company' => 'Tech Corp',
        ]);
    }

    public function test_non_admin_cannot_create_job(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(JobCreate::class)
            ->call('save')
            ->assertForbidden();
    }
}
```

### Testing Guidelines
- Write tests for happy paths, failure paths, and edge cases
- Use factories for test data creation
- Test authorization and validation rules
- Run specific tests after changes: `php artisan test --filter=JobCreateTest`
- Use descriptive test method names

## Security Guidelines

### Authorization
```php
// ✅ Good: Use policies for authorization
public function delete(): void
{
    $this->authorize('delete', $this->job);
    $this->job->delete();
}

// ✅ Good: Check permissions in Livewire components
public function save(): void
{
    if (!auth()->user()->can('create', Job::class)) {
        abort(403, 'Unauthorized');
    }
    // Save logic
}
```

### Input Validation
```php
// ✅ Good: Always validate user input
public function save(): void
{
    $this->validate([
        'title' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'description' => 'required|string|min:10',
    ]);
}
```

### Mass Assignment Protection
```php
// ✅ Good: Use $fillable or $guarded
protected $fillable = [
    'title',
    'company',
    'location',
    'description',
];
```

## Performance Best Practices

### Database Optimization
```php
// ✅ Good: Use eager loading
$jobs = Job::with(['applications', 'user'])->get();

// ✅ Good: Use pagination for large datasets
$jobs = Job::latest()->paginate(15);

// ✅ Good: Use database indexes for frequently queried columns
Schema::table('jobs', function (Blueprint $table) {
    $table->index(['status', 'created_at']);
});
```

### Livewire Performance
```php
// ✅ Good: Use wire:model (deferred) for better performance
<input wire:model="title" type="text">

// ✅ Good: Use wire:model.live only when needed
<input wire:model.live="search" type="text">

// ✅ Good: Lazy load expensive operations
public function loadJobs(): void
{
    $this->jobs = Job::with('applications')->latest()->get();
}
```

### Caching
```php
// ✅ Good: Cache expensive queries
$popularJobs = Cache::remember('popular_jobs', 3600, function () {
    return Job::withCount('applications')
        ->orderBy('applications_count', 'desc')
        ->limit(10)
        ->get();
});
```

## Code Review Checklist

### Before Submitting
- [ ] Run `vendor/bin/pint --dirty` to format code
- [ ] Run relevant tests: `php artisan test --filter=FeatureName`
- [ ] Check for authorization in all Livewire actions
- [ ] Validate all user inputs
- [ ] Use proper type declarations
- [ ] Follow naming conventions
- [ ] Add PHPDoc blocks for public methods
- [ ] Remove debug code and unused imports

### Review Criteria
- [ ] Code follows PSR-12 standards
- [ ] Proper error handling and validation
- [ ] Security considerations addressed
- [ ] Performance implications considered
- [ ] Tests cover new functionality
- [ ] Documentation is updated if needed
- [ ] No code duplication
- [ ] Follows SOLID principles

## Additional Resources

- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Livewire 3 Documentation](https://livewire.laravel.com/docs)
- [PSR-12 Coding Standards](https://www.php-fig.org/psr/psr-12/)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)

## Version Information

- **PHP**: 8.3.16
- **Laravel**: 12.31.1
- **Livewire**: 3.6.4
- **PHPUnit**: 11.5.41
- **Tailwind CSS**: 4.1.13
- **Laravel Pint**: 1.25.1

---

*Last updated: October 2025*