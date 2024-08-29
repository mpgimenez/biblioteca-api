<?php
namespace App\Services;

use App\Models\Author;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class AuthorService
{
    public function create(array $data): Author
    {
        $this->validate($data);
        return Author::create($data);
    }

    public function update(Author $author, array $data): Author
    {
        $this->validate($data);
        $author->update($data);
        return $author;
    }

    public function delete(Author $author): void
    {
        $author->delete();
    }

    private function validate(array $data): void
    {
        $validator = \Validator::make($data, [
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
