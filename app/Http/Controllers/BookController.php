<?php
namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Services\BookService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Library API", version="1.0.0")
 */

/**
 * @OA\Tag(name="Books", description="Operations related to books")
 */

/**
 * @OA\Schema(
 *     schema="Book",
 *     type="object",
 *     @OA\Property(property="id", type="integer", format="int64", description="ID of the book"),
 *     @OA\Property(property="title", type="string", description="Title of the book"),
 *     @OA\Property(property="publication_year", type="integer", format="int32", description="Publication year of the book"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the book was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the book was last updated"),
 *     @OA\Property(property="authors", type="array", @OA\Items(ref="#/components/schemas/Author"), description="List of authors associated with the book")
 * )
 */
class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @OA\Get(
     *     path="/books",
     *     tags={"Books"},
     *     summary="List all books",
     *     description="Returns a list of books",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $books = $this->bookService->getAllBooks();
        return response()->json($books);
    }

    /**
     * @OA\Post(
     *     path="/books",
     *     tags={"Books"},
     *     summary="Create a new book",
     *     description="Creates a new book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(BookRequest $request)
    {
        try {
            $data = $request->validated();
            $book = $this->bookService->create($data);
            return response()->json($book, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @OA\Get(
     *     path="/books/{id}",
     *     tags={"Books"},
     *     summary="Get a book by ID",
     *     description="Returns a single book",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the book",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $book = $this->bookService->getBook($id);
            return response()->json($book);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @OA\Put(
     *     path="/books/{id}",
     *     tags={"Books"},
     *     summary="Update an existing book",
     *     description="Updates an existing book",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the book",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book updated",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(BookRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $book = $this->bookService->getBook($id);
            $updatedBook = $this->bookService->update($book, $data);
            return response()->json($updatedBook);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Book not found'], Response::HTTP_NOT_FOUND);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @OA\Delete(
     *     path="/books/{id}",
     *     tags={"Books"},
     *     summary="Delete a book",
     *     description="Deletes a book by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the book",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Book deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $book = $this->bookService->getBook($id);
            $this->bookService->delete($book);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
