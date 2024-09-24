<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Rental;
use App\Repositories\RentalRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRentalRequest;
use App\Http\Requests\RentalHistoryRequest;

class RentalController extends Controller
{
    protected $rentalRepository;

    public function __construct(RentalRepository $rentalRepository)
    {
        $this->rentalRepository = $rentalRepository;
    }

    /**
     * Rent a book.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

/**
 * @OA\Post(
 *     path="/api/v1/rentals",
 *     summary="Create a rental",
 *     description="Rent a book for a user.",
 *     tags={"Rentals"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="book_id", type="integer", example=1, description="ID of the book to rent"),
 *             @OA\Property(property="user_id", type="integer", example=1, description="ID of the user renting the book")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Rental created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", description="ID of the rental"),
 *             @OA\Property(property="user_id", type="integer", description="ID of the user"),
 *             @OA\Property(property="book_id", type="integer", description="ID of the rented book"),
 *             @OA\Property(property="rented_at", type="string", format="date-time", description="Date and time when the book was rented"),
 *             @OA\Property(property="due_at", type="string", format="date-time", description="Due date for returning the book")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="This book is already rented.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Not Found")
 *         )
 *     )
 * )
 */


    public function store(StoreRentalRequest $request)
    {
        $bookId = $request->input('book_id');
        $userId = $request->input('user_id');

        if (Rental::where('book_id', $bookId)->whereNull('returned_at')->exists()) {
            return response()->json(['error' => 'This book is already rented.'], 400);
        }

        $rental = $this->rentalRepository->create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'rented_at' => Carbon::now(),
            'due_at' => Carbon::now()->addWeeks(2),
        ]);

        return response()->json($rental, 201);
    }

    /**
     * Return a rented book.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
/**
 * @OA\Put(
 *     path="/api/v1/rentals/return/{id}",
 *     summary="Return a rented book",
 *     security={{"sanctum":{}}},
 *     description="Mark a rented book as returned.",
 *     tags={"Rentals"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the rental to return",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Rental returned successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", description="ID of the rental"),
 *             @OA\Property(property="user_id", type="integer", description="ID of the user"),
 *             @OA\Property(property="book_id", type="integer", description="ID of the rented book"),
 *             @OA\Property(property="rented_at", type="string", format="date-time", description="Date and time when the book was rented"),
 *             @OA\Property(property="due_at", type="string", format="date-time", description="Due date for returning the book"),
 *             @OA\Property(property="returned_at", type="string", format="date-time", description="Date and time when the book was returned"),
 *             @OA\Property(property="overdue", type="boolean", description="Indicates if the rental is overdue")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="This rental has already been returned.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Not Found")
 *         )
 *     )
 * )
 */
    public function returnBook($id)
    {
        $rental = $this->rentalRepository->find($id);

        if ($rental->returned_at) {
            return response()->json(['error' => 'This rental has already been returned.'], 400);
        }
        $rental = $this->rentalRepository->update($id, [
            'returned_at' => Carbon::now(),
            'overdue' => $rental->due_at < Carbon::now(),
        ]);
        return response()->json($rental);
    }

    /**
 * @OA\Get(
 *     path="/api/v1/rentals/history",
 *     summary="Get rental history",
 *     security={{"sanctum":{}}},
 *     description="Retrieve the rental history for a specific user.",
 *     tags={"Rentals"},
 *     @OA\Parameter(
 *         name="user_id",
 *         in="query",
 *         required=true,
 *         description="ID of the user to get rental history for",
 *         @OA\Schema(type="integer",example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Rental history retrieved successfully",
 *         @OA\JsonContent(type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", description="ID of the rental"),
 *                 @OA\Property(property="user_id", type="integer", description="ID of the user"),
 *                 @OA\Property(property="book_id", type="integer", description="ID of the rented book"),
 *                 @OA\Property(property="rented_at", type="string", format="date-time", description="Date and time when the book was rented"),
 *                 @OA\Property(property="due_at", type="string", format="date-time", description="Due date for returning the book"),
 *                 @OA\Property(property="returned_at", type="string", format="date-time", description="Date and time when the book was returned"),
 *                 @OA\Property(property="overdue", type="boolean", description="Indicates if the rental is overdue")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="User ID is required.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="No rental history found for this user.")
 *         )
 *     )
 * )
 */
public function history(RentalHistoryRequest $request)
{
    $history = $this->rentalRepository->getHistory($request->user_id);
    return response()->json($history);
}

}
