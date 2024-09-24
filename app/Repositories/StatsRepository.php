<?php

namespace App\Repositories;

use App\Models\Rental;
use Illuminate\Database\Eloquent\Collection;

class StatsRepository
{
   
    public function mostOverdueBook()
    {
       return Rental::where('returned_at', null)
        ->where('due_at', '<', now())
        ->with('book')
        ->select('book_id')
        ->groupBy('book_id')
        ->orderByRaw('COUNT(*) DESC')
        ->first();
    }

    public function mostPopularBook()
    {
       return Book::withCount('rentals')
        ->orderBy('rentals_count', 'desc')
        ->first();
    }

    public function leastPopularBook()
    {
       return  Book::withCount('rentals')
       ->orderBy('rentals_count', 'asc')
       ->first();
    }

   
  
}
