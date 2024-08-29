<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use App\Services\BookService;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $bookService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookService = new BookService();
    }

    public function test_create_book_successfully()
    {
        $data = [
            'title' => 'Test Book',
            'publication_year' => 2023,
            'authors' => []
        ];

        $book = $this->bookService->create($data);

        $this->assertInstanceOf(Book::class, $book);
        $this->assertEquals('Test Book', $book->title);
    }

    public function test_create_book_validation_fails()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'title' => '',
            'publication_year' => 'invalid_year',
            'authors' => [999]
        ];

        $this->bookService->create($data);
    }

    public function test_update_book_successfully()
    {
        $book = Book::factory()->create();

        $data = [
            'title' => 'Updated Book',
            'publication_year' => 2024,
            'authors' => []
        ];

        $updatedBook = $this->bookService->update($book, $data);

        $this->assertEquals('Updated Book', $updatedBook->title);
    }

    public function test_delete_book_successfully()
    {
        $book = Book::factory()->create();

        $this->bookService->delete($book);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
