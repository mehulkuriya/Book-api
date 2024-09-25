<?php

namespace Database\Factories;

use App\Models\Rental;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RentalFactory extends Factory
{
    protected $model = Rental::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), 
            'book_id' => Book::factory(), 
            'rented_at' => Carbon::now(),
            'due_at' => Carbon::now()->addWeeks(2),
            'returned_at' => null,
            'is_overdue' => false,
        ];
    }
}
