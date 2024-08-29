<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $authorService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authorService = new AuthorService();
    }

    public function test_create_author_successfully()
    {
        $data = [
            'name' => 'Author Name',
            'birth_date' => '1990-01-01',
        ];

        $author = $this->authorService->create($data);

        $this->assertInstanceOf(Author::class, $author);
        $this->assertEquals('Author Name', $author->name);
    }

    public function test_create_author_validation_fails()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'name' => '',
            'birth_date' => 'invalid_date',
        ];

        $this->authorService->create($data);
    }

    public function test_update_author_successfully()
    {
        $author = Author::factory()->create();

        $data = [
            'name' => 'Updated Author Name',
            'birth_date' => '1980-01-01',
        ];

        $updatedAuthor = $this->authorService->update($author, $data);

        $this->assertEquals('Updated Author Name', $updatedAuthor->name);
    }

    public function test_delete_author_successfully()
    {
        $author = Author::factory()->create();

        $this->authorService->delete($author);

        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
