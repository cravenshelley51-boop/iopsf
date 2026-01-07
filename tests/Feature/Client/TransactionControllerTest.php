<?php

namespace Tests\Feature\Client;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'client']);
        $this->actingAs($this->user);
    }

    public function test_index_returns_view_with_transactions()
    {
        Transaction::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->get(route('client.transactions.index'));

        $response->assertStatus(200)
            ->assertViewIs('client.transactions.index')
            ->assertViewHas('transactions');
    }

    public function test_create_returns_view()
    {
        $response = $this->get(route('client.transactions.create'));

        $response->assertStatus(200)
            ->assertViewIs('client.transactions.create');
    }

    public function test_store_creates_new_transaction()
    {
        $response = $this->post(route('client.transactions.store'), [
            'amount' => 1000,
            'type' => 'deposit',
            'payment_method' => 'bank_transfer',
        ]);

        $response->assertRedirect(route('client.transactions.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'amount' => 1000,
            'type' => 'deposit',
            'payment_method' => 'bank_transfer',
            'status' => 'pending',
        ]);
    }

    public function test_show_returns_transaction_view()
    {
        $transaction = Transaction::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get(route('client.transactions.show', $transaction));

        $response->assertStatus(200)
            ->assertViewIs('client.transactions.show')
            ->assertViewHas('transaction', $transaction);
    }

    public function test_show_denies_access_to_other_users_transactions()
    {
        $otherUser = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->get(route('client.transactions.show', $transaction));

        $response->assertStatus(403);
    }

    public function test_store_validates_required_fields()
    {
        $response = $this->post(route('client.transactions.store'), []);

        $response->assertSessionHasErrors(['amount', 'type', 'payment_method']);
    }

    public function test_store_validates_amount_minimum()
    {
        $response = $this->post(route('client.transactions.store'), [
            'amount' => 0,
            'type' => 'deposit',
            'payment_method' => 'bank_transfer',
        ]);

        $response->assertSessionHasErrors(['amount']);
    }

    public function test_store_validates_transaction_type()
    {
        $response = $this->post(route('client.transactions.store'), [
            'amount' => 1000,
            'type' => 'invalid',
            'payment_method' => 'bank_transfer',
        ]);

        $response->assertSessionHasErrors(['type']);
    }

    public function test_store_validates_payment_method()
    {
        $response = $this->post(route('client.transactions.store'), [
            'amount' => 1000,
            'type' => 'deposit',
            'payment_method' => 'invalid',
        ]);

        $response->assertSessionHasErrors(['payment_method']);
    }
} 