<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Rental;
use Illuminate\Http\JsonResponse;
use App\Repositories\StatsRepository;

class StatsController extends Controller
{

    protected $statsRepository;

    public function __construct(StatsRepository $statsRepository)
    {
        $this->statsRepository = $statsRepository;
    }


 /**
 * @OA\Get(
 *     path="/api/v1/stats/most-overdue-book",
 *     tags={"Statistics"},
 *     summary="Get the most overdue book",
 *     security={{"sanctum":{}}},
 *     description="Retrieve the book that is currently the most overdue based on rental records.",
 *     @OA\Response(
 *         response=200,
 *         description="Successful retrieval of the most overdue book",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="title", type="string", example="Laravel for Beginners"),
 *             @OA\Property(property="author", type="string", example="John Doe"),
 *             @OA\Property(property="due_date", type="string", format="date", example="2024-09-15"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No overdue books found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="No overdue books found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="An error occurred while retrieving the most overdue book")
 *         )
 *     ),
 * )
 */

    public function mostOverdueBook(): JsonResponse
    {
        $mostOverdueBook = $this->statsRepository->mostOverdueBook();
        return response()->json($mostOverdueBook ? $mostOverdueBook->book : null);
    }

/**
 * @OA\Get(
 *     path="/api/v1/stats/most-popular-book",
 *     tags={"Statistics"},
 *     summary="Get the most popular book",
 *     security={{"sanctum":{}}},
 *     description="Retrieve the book that has the highest rental count.",
 *     @OA\Response(
 *         response=200,
 *         description="Successful retrieval of the most popular book",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="title", type="string", example="Laravel for Beginners"),
 *             @OA\Property(property="author", type="string", example="John Doe"),
 *             @OA\Property(property="rental_count", type="integer", example=10),
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No books found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="No books found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="An error occurred while retrieving the most popular book")
 *         )
 *     ),
 * )
 */

    public function mostPopularBook(): JsonResponse
    {
        $mostPopularBook = $this->statsRepository->mostPopularBook();
        return response()->json($mostPopularBook);
    }


  
/**
 * @OA\Get(
 *     path="/api/v1/stats/least-popular-book",
 *     tags={"Statistics"},
 *     summary="Get the least popular book",
 *     security={{"sanctum":{}}},
 *     description="Retrieve the book that has the lowest rental count.",
 *     @OA\Response(
 *         response=200,
 *         description="Successful retrieval of the least popular book",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="title", type="string", example="Learning PHP"),
 *             @OA\Property(property="author", type="string", example="Jane Smith"),
 *             @OA\Property(property="rental_count", type="integer", example=1),
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No books found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="No books found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="An error occurred while retrieving the least popular book")
 *         )
 *     ),
 * 
 * )
 */

    public function leastPopularBook(): JsonResponse
    {
        $leastPopularBook = $this->statsRepository->leastPopularBook();
        return response()->json($leastPopularBook);
    }

}