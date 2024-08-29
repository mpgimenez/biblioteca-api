<?php
namespace App\Services;

use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class LoanService
{
    public function create(array $data): Loan
    {
        $this->validate($data);

        $loan = Loan::create([
            'user_id' => $data['user_id'],
            'book_id' => $data['book_id'],
            'loan_date' => $data['loan_date'],
            'return_date' => $data['return_date'] ?? null,
        ]);

        return $loan;
    }

    public function update(Loan $loan, array $data): Loan
    {
        $this->validate($data);

        $loan->update([
            'user_id' => $data['user_id'],
            'book_id' => $data['book_id'],
            'loan_date' => $data['loan_date'],
            'return_date' => $data['return_date'] ?? null,
        ]);

        return $loan;
    }

    public function delete(Loan $loan): void
    {
        $loan->delete();
    }

    public function getLoan(int $id): Loan
    {
        $loan = Loan::with('user', 'book')->find($id);

        if (!$loan) {
            throw new ModelNotFoundException('Loan not found');
        }

        return $loan;
    }

    public function getAllLoans()
    {
        return Loan::with('user', 'book')->get();
    }

    private function validate(array $data): void
    {
        $validator = \Validator::make($data, [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
