<?php

namespace Tests\Feature\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_routes()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)
            ->get('/admin/dashboard');
            
        $response->assertStatus(200);
    }

    public function test_client_cannot_access_admin_routes()
    {
        $client = User::factory()->create(['role' => 'client']);
        
        $response = $this->actingAs($client)
            ->get('/admin/dashboard');
            
        $response->assertStatus(403);
    }

    public function test_client_can_access_client_routes()
    {
        $client = User::factory()->create(['role' => 'client']);
        
        $response = $this->actingAs($client)
            ->get('/client/dashboard');
            
        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_client_routes()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)
            ->get('/client/dashboard');
            
        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_access_protected_routes()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(302); // Redirect to login
        
        $response = $this->get('/client/dashboard');
        $response->assertStatus(302); // Redirect to login
    }
} 