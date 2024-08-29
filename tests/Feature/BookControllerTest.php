<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class BookControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_list_books()
    {
        $this->actingAs($this->user, 'sanctum');

        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_create_book_successfully()
    {
        $this->actingAs($this->user, 'sanctum');

        $data = [
            'title' => 'New Book',
            'publication_year' => 2023,
            'authors' => []
        ];

        $response = $this->postJson('/api/books', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'New Book']);
    }

    public function test_show_book()
    {
        $this->actingAs($this->user, 'sanctum');

        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $book->title]);
    }

    public function test_update_book_successfully()
    {
        $this->actingAs($this->user, 'sanctum');

        $book = Book::factory()->create();

        $data = [
            'title' => 'Updated Book',
            'publication_year' => 2024,
            'authors' => []
        ];

        $response = $this->putJson("/api/books/{$book->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Updated Book']);
    }

    public function test_delete_book_successfully()
    {
        $this->actingAs($this->user, 'sanctum');

        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
