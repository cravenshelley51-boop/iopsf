<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Models\AuditLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WithdrawalImprovementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $client;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup roles
        $adminRole = Role::firstOrCreate(['name' => Role::ADMIN]);
        $clientRole = Role::firstOrCreate(['name' => Role::CLIENT]);

        // Setup users
        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($adminRole);

        $this->client = User::factory()->create(['gold_balance' => 100.00]);
        $this->client->roles()->attach($clientRole);
    }

    public function test_client_can_create_withdrawal_request()
    {
        $this->actingAs($this->client);

        $response = $this->post(route('withdrawal-requests.store'), [
            'amount' => 10.00,
            'purpose' => 'Test withdrawal',
        ]);

        $response->assertRedirect(route('withdrawal-requests.my'));
        $this->assertDatabaseHas('withdrawal_requests', [
            'user_id' => $this->client->id,
            'amount' => 10.00,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'withdrawal_requested',
            'type' => 'transaction',
        ]);
    }

    public function test_client_can_cancel_pending_withdrawal_request()
    {
        $request = WithdrawalRequest::create([
            'user_id' => $this->client->id,
            'amount' => 10.00,
            'status' => 'pending',
        ]);

        $this->actingAs($this->client);

        $response = $this->post(route('withdrawal-requests.cancel', $request));

        $response->assertRedirect(route('withdrawal-requests.my'));
        $this->assertDatabaseHas('withdrawal_requests', [
            'id' => $request->id,
            'status' => 'rejected',
            'admin_notes' => 'Cancelled by user',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'withdrawal_cancelled',
        ]);
    }

    public function test_admin_can_approve_withdrawal_with_notes()
    {
        $request = WithdrawalRequest::create([
            'user_id' => $this->client->id,
            'amount' => 10.00,
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin);

        $response = $this->put(route('admin.withdrawal-requests.update', $request), [
            'status' => 'approved',
            'admin_notes' => 'Approved for testing',
        ]);

        $response->assertRedirect(route('admin.withdrawal-requests.index'));
        $this->assertDatabaseHas('withdrawal_requests', [
            'id' => $request->id,
            'status' => 'approved',
            'admin_notes' => 'Approved for testing',
            'processed_by' => $this->admin->id,
        ]);

        $this->client->refresh();
        $this->assertEquals(90.00, $this->client->gold_balance);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'withdrawal_approved',
        ]);
    }

    public function test_admin_can_reject_withdrawal_with_notes()
    {
        $request = WithdrawalRequest::create([
            'user_id' => $this->client->id,
            'amount' => 10.00,
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin);

        $response = $this->put(route('admin.withdrawal-requests.update', $request), [
            'status' => 'rejected',
            'admin_notes' => 'Rejected for testing',
        ]);

        $response->assertRedirect(route('admin.withdrawal-requests.index'));
        $this->assertDatabaseHas('withdrawal_requests', [
            'id' => $request->id,
            'status' => 'rejected',
            'admin_notes' => 'Rejected for testing',
        ]);

        $this->client->refresh();
        $this->assertEquals(100.00, $this->client->gold_balance);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'withdrawal_rejected',
        ]);
    }
}
