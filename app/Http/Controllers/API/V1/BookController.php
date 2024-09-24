<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\BookRepository;


class BookController extends Controller
{
    
/**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Book Api documentation",
     *      description="Book Api documentation",
     *      @OA\Contact(
     *          email="kuriyamehul@gmail.com"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )
     
    
 * @OA\SecurityScheme(
 *      securityScheme="sanctum",
 *      name="Authorization",
 *      type="http",
 *      scheme="bearer",
 *      in="header",
 * )

     *
     * @OA\Tag(
     *     name="Book Api",
     *     description="API Endpoints of Book Api"
     * )
     */
    
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    /**
     * Display a listing of all books.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
 * @OA\Get(
 *     path="/api/v1/books",
 *     summary="Retrieve a List of Books",
 *     description="Fetches a list of all available books. Authentication is required.",
 *     operationId="getBooks",
 *     tags={"Books"},
 *      security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Books retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true, description="Indicates the success of the operation"),
 *             @OA\Property(property="data", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1, description="Book ID"),
 *                 @OA\Property(property="title", type="string", example="1984", description="Title of the book"),
 *                 @OA\Property(property="author", type="string", example="George Orwell", description="Author of the book"),
 *                 @OA\Property(property="published_year", type="integer", example=1949, description="Year the book was published"),
 *                 @OA\Property(property="is_available", type="boolean", example=true, description="Availability status of the book")
 *             ))
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false, description="Indicates failure"),
 *             @OA\Property(property="message", type="string", example="Failed to fetch books", description="Error message")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     )
 * )
 */
 

    public function index()
    {
        try {
            $books = $this->bookRepository->all();
            return response()->json(['success' => true, 'data' => $books], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch books'], 500);
        }
    }

    /**
     * Search for books by title or genre.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */


    /**
 * @OA\Get(
 *     path="/api/v1/books/search",
 *     tags={"Books"},
 *     summary="Search for books",
 *     security={{"sanctum":{}}},
 *     description="Search for books by a keyword.",
 *     @OA\Parameter(
 *         name="search",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="string", example="Laravel")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful search",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="title", type="string", example="Laravel for Beginners"),
 *                     @OA\Property(property="author", type="string", example="John Doe")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Failed to search books",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Failed to search books"),
 *         )
 *     ),
 * )
 */



    public function search(Request $request)
    {
        try {
            $books = $this->bookRepository->search($request->search);
            return response()->json(['success' => true, 'data' => $books], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to search books'], 500);
        }
    }

}
