<?php

namespace Tests\Feature\Client;

use App\Models\Document;
use App\Models\Rate;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'client']);
        $this->actingAs($this->user);
    }

    public function test_index_returns_view_with_correct_data()
    {
        // Create test data
        Document::factory()->count(2)->create(['user_id' => $this->user->id]);
        Document::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending'
        ]);

        Transaction::factory()->count(2)->create(['user_id' => $this->user->id]);
        Transaction::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending'
        ]);

        $currentRate = Rate::factory()->create([
            'valid_from' => now()->subDay(),
            'valid_to' => now()->addDay(),
        ]);

        $response = $this->get(route('client.dashboard'));

        $response->assertStatus(200)
            ->assertViewIs('client.dashboard')
            ->assertViewHas('stats')
            ->assertViewHas('recentTransactions')
            ->assertViewHas('recentDocuments')
            ->assertViewHas('currentRate');

        $viewData = $response->viewData('stats');
        $this->assertEquals(3, $viewData['total_documents']);
        $this->assertEquals(1, $viewData['pending_documents']);
        $this->assertEquals(3, $viewData['total_transactions']);
        $this->assertEquals(1, $viewData['pending_transactions']);
    }

    public function test_index_shows_only_user_specific_data()
    {
        $otherUser = User::factory()->create();
        
        // Create documents and transactions for both users
        Document::factory()->count(2)->create(['user_id' => $this->user->id]);
        Document::factory()->count(3)->create(['user_id' => $otherUser->id]);

        Transaction::factory()->count(2)->create(['user_id' => $this->user->id]);
        Transaction::factory()->count(3)->create(['user_id' => $otherUser->id]);

        $response = $this->get(route('client.dashboard'));

        $viewData = $response->viewData('stats');
        $this->assertEquals(2, $viewData['total_documents']);
        $this->assertEquals(2, $viewData['total_transactions']);
    }

    public function test_index_shows_only_recent_transactions()
    {
        Transaction::factory()->count(10)->create(['user_id' => $this->user->id]);

        $response = $this->get(route('client.dashboard'));

        $recentTransactions = $response->viewData('recentTransactions');
        $this->assertCount(5, $recentTransactions);
    }

    public function test_index_shows_only_recent_documents()
    {
        Document::factory()->count(10)->create(['user_id' => $this->user->id]);

        $response = $this->get(route('client.dashboard'));

        $recentDocuments = $response->viewData('recentDocuments');
        $this->assertCount(5, $recentDocuments);
    }

    public function test_index_shows_current_rate()
    {
        $currentRate = Rate::factory()->create([
            'valid_from' => now()->subDay(),
            'valid_to' => now()->addDay(),
        ]);

        $response = $this->get(route('client.dashboard'));

        $response->assertViewHas('currentRate', $currentRate);
    }

    public function test_index_handles_no_current_rate()
    {
        $response = $this->get(route('client.dashboard'));

        $response->assertViewHas('currentRate', null);
    }

    public function test_client_can_view_dashboard()
    {
        $client = User::factory()->create(['role' => 'client']);
        
        $response = $this->actingAs($client)
            ->get(route('client.dashboard'));
            
        $response->assertStatus(200)
            ->assertViewIs('client.dashboard');
    }

    public function test_dashboard_shows_correct_statistics()
    {
        $client = User::factory()->create(['role' => 'client']);
        
        // Create test data for this client
        $pendingDocuments = Document::factory()->count(2)->create([
            'user_id' => $client->id,
            'status' => 'pending'
        ]);
        $completedDocuments = Document::factory()->count(3)->create([
            'user_id' => $client->id,
            'status' => 'completed'
        ]);
        $pendingTransactions = Transaction::factory()->count(2)->create([
            'user_id' => $client->id,
            'status' => Transaction::STATUS_PENDING
        ]);
        $completedTransactions = Transaction::factory()->count(3)->create([
            'user_id' => $client->id,
            'status' => Transaction::STATUS_COMPLETED
        ]);
        
        $response = $this->actingAs($client)
            ->get(route('client.dashboard'));
            
        $response->assertViewHas('stats', [
            'total_documents' => 5,
            'pending_documents' => 2,
            'total_transactions' => 5,
            'pending_transactions' => 2
        ]);
    }

    public function test_dashboard_shows_recent_transactions()
    {
        $client = User::factory()->create(['role' => 'client']);
        $transactions = Transaction::factory()->count(5)->create(['user_id' => $client->id]);
        
        $response = $this->actingAs($client)
            ->get(route('client.dashboard'));
            
        $response->assertViewHas('recentTransactions')
            ->assertViewHas('recentTransactions', function ($recentTransactions) {
                return $recentTransactions->count() === 5;
            });
    }

    public function test_dashboard_shows_recent_documents()
    {
        $client = User::factory()->create(['role' => 'client']);
        $documents = Document::factory()->count(5)->create(['user_id' => $client->id]);
        
        $response = $this->actingAs($client)
            ->get(route('client.dashboard'));
            
        $response->assertViewHas('recentDocuments')
            ->assertViewHas('recentDocuments', function ($recentDocuments) {
                return $recentDocuments->count() === 5;
            });
    }

    public function test_dashboard_shows_current_rate()
    {
        $client = User::factory()->create(['role' => 'client']);
        $rate = Rate::factory()->create();
        
        $response = $this->actingAs($client)
            ->get(route('client.dashboard'));
            
        $response->assertViewHas('currentRate', $rate);
    }

    public function test_non_client_cannot_access_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)
            ->get(route('client.dashboard'));
            
        $response->assertStatus(403);
    }
} 