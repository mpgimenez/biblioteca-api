<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_list_authors()
    {
        $this->actingAs($this->user, 'sanctum');

        Author::factory()->count(3)->create();

        $response = $this->getJson('/api/authors');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_create_author_successfully()
    {
        $this->actingAs($this->user, 'sanctum');

        $data = [
            'name' => 'New Author',
            'birth_date' => '1990-01-01',
        ];

        $response = $this->postJson('/api/authors', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'New Author']);
    }

    public function test_show_author()
    {
        $this->actingAs($this->user, 'sanctum');

        $author = Author::factory()->create();

        $response = $this->getJson("/api/authors/{$author->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $author->name]);
    }

    public function test_update_author_successfully()
    {
        $this->actingAs($this->user, 'sanctum');

        $author = Author::factory()->create();

        $data = [
            'name' => 'Updated Author',
            'birth_date' => '1985-05-05',
        ];

        $response = $this->putJson("/api/authors/{$author->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Author']);
    }

    public function test_delete_author_successfully()
    {
        $this->actingAs($this->user, 'sanctum');

        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/authors/{$author->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
