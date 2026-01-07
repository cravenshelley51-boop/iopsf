<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BalanceVisibilityTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
        $this->user = User::factory()->client()->create([
            'gold_balance' => 1000,
            'pin_code' => '1234',
            'balance_visibility' => false
        ]);
    }

    public function test_can_toggle_balance_visibility_with_correct_pin()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('dashboard.toggle-balance-visibility'), [
                'pin_code' => '1234'
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'balance_visibility' => true
            ]);

        $this->user->refresh();
        $this->assertTrue($this->user->balance_visibility);
    }

    public function test_cannot_toggle_balance_visibility_with_incorrect_pin()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('dashboard.toggle-balance-visibility'), [
                'pin_code' => '0000'
            ]);

        $response->assertJson([
            'success' => false,
            'message' => 'Invalid PIN code'
        ]);

        $this->user->refresh();
        $this->assertFalse($this->user->balance_visibility);
    }

    public function test_no_pin_required_to_hide_balance()
    {
        $this->user->update(['balance_visibility' => true]);

        $response = $this->actingAs($this->user)
            ->postJson(route('dashboard.toggle-balance-visibility'));

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'balance_visibility' => false
            ]);

        $this->user->refresh();
        $this->assertFalse($this->user->balance_visibility);
    }
}
