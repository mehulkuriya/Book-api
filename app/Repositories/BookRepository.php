<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookRepository
{
    /**
     * Get all books.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Book::all();
    }

    /**
     * Find a book by its ID.
     *
     * @param int $id
     * @return Book
     */
    public function find(int $id): Book
    {
        return Book::findOrFail($id);
    }

    /**
     * Search for books by query.
     *
     * @param string $query
     * @return Collection
     */
    public function search(string $query): Collection
    {
        return Book::where('title', 'like', "%$query%")
                    ->orWhere('author', 'like', "%$query%")
                    ->orWhere('genre', 'like', "%$query%")
                    ->get();
    }

}
