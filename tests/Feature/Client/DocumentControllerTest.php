<?php

namespace Tests\Feature\Client;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'client']);
        $this->actingAs($this->user);
    }

    public function test_index_returns_view_with_documents()
    {
        Document::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->get(route('client.documents.index'));

        $response->assertStatus(200)
            ->assertViewIs('client.documents.index')
            ->assertViewHas('documents');
    }

    public function test_create_returns_view()
    {
        $response = $this->get(route('client.documents.create'));

        $response->assertStatus(200)
            ->assertViewIs('client.documents.create');
    }

    public function test_store_creates_new_document()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('document.jpg');

        $response = $this->post(route('client.documents.store'), [
            'type' => 'passport',
            'document' => $file,
        ]);

        $response->assertRedirect(route('client.documents.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('documents', [
            'user_id' => $this->user->id,
            'type' => 'passport',
            'status' => 'pending',
        ]);

        Storage::disk('public')->assertExists('documents/' . $file->hashName());
    }

    public function test_show_returns_document_view()
    {
        $document = Document::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get(route('client.documents.show', $document));

        $response->assertStatus(200)
            ->assertViewIs('client.documents.show')
            ->assertViewHas('document', $document);
    }

    public function test_show_denies_access_to_other_users_documents()
    {
        $otherUser = User::factory()->create();
        $document = Document::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->get(route('client.documents.show', $document));

        $response->assertStatus(403);
    }
} 