<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        // Create required data for dashboard
        User::factory()->create();
        Category::factory()->create();
        
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
