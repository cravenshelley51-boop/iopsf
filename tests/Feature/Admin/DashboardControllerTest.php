<?php

namespace Tests\Feature\Admin;

use App\Models\Document;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard'));
            
        $response->assertStatus(200)
            ->assertViewIs('admin.dashboard');
    }

    public function test_dashboard_shows_correct_statistics()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Create test data
        $clients = User::factory()->count(3)->create(['role' => 'client']);
        $pendingDocuments = Document::factory()->count(2)->create(['status' => 'pending']);
        $completedDocuments = Document::factory()->count(3)->create(['status' => 'completed']);
        $pendingTransactions = Transaction::factory()->count(2)->create(['status' => Transaction::STATUS_PENDING]);
        $completedTransactions = Transaction::factory()->count(3)->create(['status' => Transaction::STATUS_COMPLETED]);
        
        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard'));
            
        $response->assertViewHas('stats', [
            'total_users' => 3,
            'pending_documents' => 2,
            'pending_transactions' => 2,
            'total_transactions' => 5
        ]);
    }

    public function test_dashboard_shows_recent_transactions()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $transactions = Transaction::factory()->count(5)->create();
        
        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard'));
            
        $response->assertViewHas('recentTransactions')
            ->assertViewHas('recentTransactions', function ($recentTransactions) {
                return $recentTransactions->count() === 5;
            });
    }

    public function test_dashboard_shows_pending_documents()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pendingDocuments = Document::factory()->count(5)->create(['status' => 'pending']);
        
        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard'));
            
        $response->assertViewHas('pendingDocuments')
            ->assertViewHas('pendingDocuments', function ($pendingDocuments) {
                return $pendingDocuments->count() === 5;
            });
    }

    public function test_non_admin_cannot_access_dashboard()
    {
        $client = User::factory()->create(['role' => 'client']);
        
        $response = $this->actingAs($client)
            ->get(route('admin.dashboard'));
            
        $response->assertStatus(403);
    }
} 