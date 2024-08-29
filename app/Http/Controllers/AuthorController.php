<?php
namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Models\Author;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Library API", version="1.0.0")
 */

/**
 * @OA\Tag(name="Authors", description="Operations related to authors")
 */

 /**
 * @OA\Schema(
 *     schema="Author",
 *     type="object",
 *     @OA\Property(property="id", type="integer", format="int64", description="ID of the author"),
 *     @OA\Property(property="name", type="string", description="Name of the author"),
 *     @OA\Property(property="birth_date", type="string", format="date", description="Birth date of the author"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the author was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the author was last updated")
 * )
 */
class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

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
    public function index()
    {
        $authors = Author::all();
        return response()->json($authors);
    }

    /**
     * @OA\Post(
     *     path="/authors",
     *     tags={"Authors"},
     *     summary="Create a new author",
     *     description="Creates a new author",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Author created",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $author = $this->authorService->create($request->all());
            return response()->json($author, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     *     path="/authors/{id}",
     *     tags={"Authors"},
     *     summary="Get an author by ID",
     *     description="Returns a single author",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the author",
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
    public function show($id)
    {
        try {
            $author = Author::findOrFail($id);
            return response()->json($author);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @OA\Put(
     *     path="/authors/{id}",
     *     tags={"Authors"},
     *     summary="Update an existing author",
     *     description="Updates an existing author",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the author",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author updated",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $author = Author::findOrFail($id);
            $updatedAuthor = $this->authorService->update($author, $request->all());
            return response()->json($updatedAuthor);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Author not found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Delete(
     *     path="/authors/{id}",
     *     tags={"Authors"},
     *     summary="Delete an author",
     *     description="Deletes an author by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the author",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Author deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $author = Author::findOrFail($id);
            $this->authorService->delete($author);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Author not found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
