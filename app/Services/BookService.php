<?php
namespace App\Services;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class BookService
{
    public function create(array $data): Book
    {
        $this->validate($data);

        $book = Book::create([
            'title' => $data['title'],
            'publication_year' => $data['publication_year'],
        ]);

        if (isset($data['authors'])) {
            $authors = Author::find($data['authors']);
            $book->authors()->sync($authors);
        }

        return $book;
    }

    public function update(Book $book, array $data): Book
    {
        $this->validate($data);

        $book->update([
            'title' => $data['title'],
            'publication_year' => $data['publication_year'],
        ]);

        if (isset($data['authors'])) {
            $authors = Author::find($data['authors']);
            $book->authors()->sync($authors);
        }

        return $book;
    }

    public function delete(Book $book): void
    {
        $book->delete();
    }

    public function getBook(int $id): Book
    {
        $book = Book::with('authors')->find($id);

        if (!$book) {
            throw new ModelNotFoundException('Book not found');
        }

        return $book;
    }

    public function getAllBooks()
    {
        return Book::with('authors')->get(); // Obtém todos os livros com seus autores associados
    }

    private function validate(array $data): void
    {
        $validator = \Validator::make($data, [
            'title' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'authors' => 'nullable|array',
            'authors.*' => 'exists:authors,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
