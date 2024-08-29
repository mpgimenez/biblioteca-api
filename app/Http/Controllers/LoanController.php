<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Library API", version="1.0.0")
 */

/**
 * @OA\Tag(name="Loans", description="Operations related to loans")
 */

 /**
 * @OA\Schema(
 *     schema="Loan",
 *     type="object",
 *     @OA\Property(property="id", type="integer", format="int64", description="ID of the loan"),
 *     @OA\Property(property="user_id", type="integer", format="int64", description="ID of the user who borrowed the book"),
 *     @OA\Property(property="book_id", type="integer", format="int64", description="ID of the borrowed book"),
 *     @OA\Property(property="borrowed_at", type="string", format="date-time", description="Date when the book was borrowed"),
 *     @OA\Property(property="returned_at", type="string", format="date-time", description="Date when the book was returned"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the loan record was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the loan record was last updated"),
 *     @OA\Property(property="book", ref="#/components/schemas/Book", description="Details of the borrowed book"),
 *     @OA\Property(property="user", ref="#/components/schemas/User", description="Details of the user who borrowed the book")
 * )
 */

class LoanController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
        $this->middleware('auth:sanctum'); // Garante que apenas usuários autenticados possam acessar os métodos
    }

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
    public function index()
    {
        $loans = $this->loanService->getAllLoans();
        return response()->json($loans);
    }

    /**
     * @OA\Post(
     *     path="/loans",
     *     tags={"Loans"},
     *     summary="Create a new loan",
     *     description="Creates a new loan",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Loan")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Loan created",
     *         @OA\JsonContent(ref="#/components/schemas/Loan")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(LoanRequest $request)
    {
        try {
            $data = $request->validated();
            $loan = $this->loanService->create($data);
            return response()->json($loan, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @OA\Get(
     *     path="/loans/{id}",
     *     tags={"Loans"},
     *     summary="Get a loan by ID",
     *     description="Returns a single loan",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the loan",
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
    public function show($id)
    {
        try {
            $loan = $this->loanService->getLoan($id);
            return response()->json($loan);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Loan not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @OA\Put(
     *     path="/loans/{id}",
     *     tags={"Loans"},
     *     summary="Update an existing loan",
     *     description="Updates an existing loan",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the loan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Loan")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Loan updated",
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
    public function update(LoanRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $loan = $this->loanService->getLoan($id);
            $updatedLoan = $this->loanService->update($loan, $data);
            return response()->json($updatedLoan);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Loan not found'], Response::HTTP_NOT_FOUND);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @OA\Delete(
     *     path="/loans/{id}",
     *     tags={"Loans"},
     *     summary="Delete a loan",
     *     description="Deletes a loan by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the loan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Loan deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Loan not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $loan = $this->loanService->getLoan($id);
            $this->loanService->delete($loan);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Loan not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
