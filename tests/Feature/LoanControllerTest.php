<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class LoanControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_list_loans()
    {
        $this->actingAs($this->user, 'sanctum');

        $book = Book::factory()->create();
        Loan::factory()->count(3)->create(['book_id' => $book->id, 'user_id' => $this->user->id]);

        $response = $this->getJson('/api/loans');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_create_loan_successfully()
    {
        $this->actingAs($this->user, 'sanctum');

        $book = Book::factory()->create();

        $data = [
            'user_id' => $this->user->id,
            'book_id' => $book->id,
            'loan_date' => now()->toDateString(),
            'return_date' => now()->addDays(7)->toDateString(),
        ];

        $response = $this->postJson('/api/loans', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['book_id' => $book->id, 'user_id' => $this->user->id]);
    }

    public function test_show_loan()
    {
        $this->actingAs($this->user, 'sanctum');

        $loan = Loan::factory()->create(['user_id' => $this->user->id]);

        $response = $this->getJson("/api/loans/{$loan->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $loan->id]);
    }
}
