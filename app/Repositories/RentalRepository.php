<?php

namespace App\Repositories;

use App\Models\Rental;
use Illuminate\Database\Eloquent\Collection;

class RentalRepository
{
    /**
     * Create a new rental record.
     *
     * @param array $data
     * @return Rental
     */
    public function create(array $data): Rental
    {
        return Rental::create($data);
    }

    /**
     * Update a rental record.
     *
     * @param int $id
     * @param array $data
     * @return Rental
     */
    public function update(int $id, array $data): Rental
    {
        $rental = Rental::findOrFail($id);
        $rental->update($data);

        return $rental;
    }

    /**
     * Get rental history for a user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getHistory(int $userId): Collection
    {
        return Rental::where('user_id', $userId)->with('book')->get();
    }

    /**
     * Find a rental by its ID.
     *
     * @param int $id
     * @return Rental
     */
    public function find(int $id): Rental
    {
        return Rental::findOrFail($id);
    }
}
