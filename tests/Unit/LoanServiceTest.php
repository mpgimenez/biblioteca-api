<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use App\Services\LoanService;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $loanService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loanService = new LoanService();
    }

    public function test_create_loan_successfully()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $data = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'loan_date' => now(),
            'return_date' => now()->addDays(7),
        ];

        $loan = $this->loanService->create($data);

        $this->assertInstanceOf(Loan::class, $loan);
        $this->assertEquals($user->id, $loan->user_id);
        $this->assertEquals($book->id, $loan->book_id);
    }

    public function test_create_loan_validation_fails()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'user_id' => null, // Invalid user_id
            'book_id' => null, // Invalid book_id
            'loan_date' => 'invalid_date', // Invalid date
            'return_date' => 'invalid_date', // Invalid date
        ];

        $this->loanService->create($data);
    }

    public function test_list_loans()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        Loan::factory()->count(3)->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $loans = $this->loanService->getAllLoans();

        $this->assertCount(3, $loans);
    }
}
