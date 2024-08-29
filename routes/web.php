<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    // authors
    Route::prefix('authors')->group(function () {
        /**
         * @OA\Get(
         *     path="/authors",
         *     tags={"Authors"},
         *     summary="List all authors",
         *     description="Returns a list of authors",
         *     @OA\Response(
         *         response=200,
         *         description="Successful operation",
         *         @OA\JsonContent(
         *             type="array",
         *             @OA\Items(ref="#/components/schemas/Author")
         *         )
         *     )
         * )
         */
        Route::get('/', [AuthorController::class, 'index']);

        /**
         * @OA\Post(
         *     path="/authors",
         *     tags={"Authors"},
         *     summary="Create a new author",
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"name", "birth_date"},
         *             @OA\Property(property="name", type="string", example="John Doe"),
         *             @OA\Property(property="birth_date", type="string", format="date", example="1970-01-01")
         *         )
         *     ),
         *     @OA\Response(
         *         response=201,
         *         description="Author created successfully",
         *         @OA\JsonContent(ref="#/components/schemas/Author")
         *     ),
         *     @OA\Response(
         *         response=422,
         *         description="Validation error"
         *     )
         * )
         */
        Route::post('/', [AuthorController::class, 'store']);

        /**
         * @OA\Get(
         *     path="/authors/{id}",
         *     tags={"Authors"},
         *     summary="Get a specific author",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Author ID",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Successful operation",
         *         @OA\JsonContent(ref="#/components/schemas/Author")
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Author not found"
         *     )
         * )
         */
        Route::get('/{id}', [AuthorController::class, 'show']);

        /**
         * @OA\Put(
         *     path="/authors/{id}",
         *     tags={"Authors"},
         *     summary="Update a specific author",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Author ID",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"name", "birth_date"},
         *             @OA\Property(property="name", type="string", example="John Doe Updated"),
         *             @OA\Property(property="birth_date", type="string", format="date", example="1970-01-01")
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Author updated successfully",
         *         @OA\JsonContent(ref="#/components/schemas/Author")
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Author not found"
         *     ),
         *     @OA\Response(
         *         response=422,
         *         description="Validation error"
         *     )
         * )
         */
        Route::put('/{id}', [AuthorController::class, 'update']);

        /**
         * @OA\Delete(
         *     path="/authors/{id}",
         *     tags={"Authors"},
         *     summary="Delete a specific author",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Author ID",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\Response(
         *         response=204,
         *         description="Author deleted successfully"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Author not found"
         *     )
         * )
         */
        Route::delete('/{id}', [AuthorController::class, 'destroy']);
    });

    // books
    Route::prefix('books')->group(function () {
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
        Route::get('/', [BookController::class, 'index']);

        /**
         * @OA\Post(
         *     path="/books",
         *     tags={"Books"},
         *     summary="Create a new book",
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"title", "publication_year"},
         *             @OA\Property(property="title", type="string", example="A Great Book"),
         *             @OA\Property(property="publication_year", type="integer", example=2023),
         *             @OA\Property(property="authors", type="array", @OA\Items(type="integer")),
         *         )
         *     ),
         *     @OA\Response(
         *         response=201,
         *         description="Book created successfully",
         *         @OA\JsonContent(ref="#/components/schemas/Book")
         *     ),
         *     @OA\Response(
         *         response=422,
         *         description="Validation error"
         *     )
         * )
         */
        Route::post('/', [BookController::class, 'store']);

        /**
         * @OA\Get(
         *     path="/books/{id}",
         *     tags={"Books"},
         *     summary="Get a specific book",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Book ID",
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
        Route::get('/{id}', [BookController::class, 'show']);

        /**
         * @OA\Put(
         *     path="/books/{id}",
         *     tags={"Books"},
         *     summary="Update a specific book",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Book ID",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"title", "publication_year"},
         *             @OA\Property(property="title", type="string", example="A Great Book Updated"),
         *             @OA\Property(property="publication_year", type="integer", example=2024),
         *             @OA\Property(property="authors", type="array", @OA\Items(type="integer")),
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Book updated successfully",
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
        Route::put('/{id}', [BookController::class, 'update']);

        /**
         * @OA\Delete(
         *     path="/books/{id}",
         *     tags={"Books"},
         *     summary="Delete a specific book",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Book ID",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\Response(
         *         response=204,
         *         description="Book deleted successfully"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Book not found"
         *     )
         * )
         */
        Route::delete('/{id}', [BookController::class, 'destroy']);
    });

    // loans
    Route::prefix('loans')->group(function () {
        /**
         * @OA\Get(
         *     path="/loans",
         *     tags={"Loans"},
         *     summary="List all loans",
         *     description="Returns a list of loans",
         *     @OA\Response(
         *         response=200,
         *         description="Successful operation",
         *         @OA\JsonContent(
         *             type="array",
         *             @OA\Items(ref="#/components/schemas/Loan")
         *         )
         *     )
         * )
         */
        Route::get('/', [LoanController::class, 'index']);

        /**
         * @OA\Post(
         *     path="/loans",
         *     tags={"Loans"},
         *     summary="Create a new loan",
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"book_id", "user_id", "loan_date", "return_date"},
         *             @OA\Property(property="book_id", type="integer", example=1),
         *             @OA\Property(property="user_id", type="integer", example=1),
         *             @OA\Property(property="loan_date", type="string", format="date", example="2024-01-01"),
         *             @OA\Property(property="return_date", type="string", format="date", example="2024-01-15")
         *         )
         *     ),
         *     @OA\Response(
         *         response=201,
         *         description="Loan created successfully",
         *         @OA\JsonContent(ref="#/components/schemas/Loan")
         *     ),
         *     @OA\Response(
         *         response=422,
         *         description="Validation error"
         *     )
         * )
         */
        Route::post('/', [LoanController::class, 'store']);

        /**
         * @OA\Get(
         *     path="/loans/{id}",
         *     tags={"Loans"},
         *     summary="Get a specific loan",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Loan ID",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Successful operation",
         *         @OA\JsonContent(ref="#/components/schemas/Loan")
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Loan not found"
         *     )
         * )
         */
        Route::get('/{id}', [LoanController::class, 'show']);

        /**
         * @OA\Put(
         *     path="/loans/{id}",
         *     tags={"Loans"},
         *     summary="Update a specific loan",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Loan ID",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"book_id", "user_id", "loan_date", "return_date"},
         *             @OA\Property(property="book_id", type="integer", example=1),
         *             @OA\Property(property="user_id", type="integer", example=1),
         *             @OA\Property(property="loan_date", type="string", format="date", example="2024-01-01"),
         *             @OA\Property(property="return_date", type="string", format="date", example="2024-01-15")
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Loan updated successfully",
         *         @OA\JsonContent(ref="#/components/schemas/Loan")
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Loan not found"
         *     ),
         *     @OA\Response(
         *         response=422,
         *         description="Validation error"
         *     )
         * )
         */
        Route::put('/{id}', [LoanController::class, 'update']);

        /**
         * @OA\Delete(
         *     path="/loans/{id}",
         *     tags={"Loans"},
         *     summary="Delete a specific loan",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Loan ID",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\Response(
         *         response=204,
         *         description="Loan deleted successfully"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Loan not found"
         *     )
         * )
         */
        Route::delete('/{id}', [LoanController::class, 'destroy']);
    });

});
