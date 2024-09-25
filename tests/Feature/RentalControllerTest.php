<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Rental;
use App\Models\User;
use App\Repositories\RentalRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Mockery;

class RentalControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $rentalRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rentalRepository = Mockery::mock(RentalRepository::class);
        $this->app->instance(RentalRepository::class, $this->rentalRepository);
        $user = User::factory()->create();
        $this->token = $user->createToken('API Token')->plainTextToken;
    }

    public function test_successfully_rents_a_book()
    {
        // Arrange: Create a book
        $book = Book::factory()->create();

        // Mock the rental repository to return a rental object
        $this->rentalRepository->shouldReceive('create')->once()->andReturn(new Rental([
            'id' => 1,
            'user_id' => 1,
            'book_id' => $book->id,
            'rented_at' => Carbon::now(),
            'due_at' => Carbon::now()->addWeeks(2),
        ]));

        // Act: Simulate a rental request
        $response = $this->withHeader('Authorization', "Bearer {$this->token}")->postJson('/api/v1/rentals', [
            'book_id' => $book->id,
            'user_id' => 1,
        ]);
        $response->assertStatus(201);
    }

    public function test_renting_an_already_rented_book_returns_error()
    {
        // Arrange: Create a rented book
        $book = Book::factory()->create();
        Rental::create([
            'user_id' => 1,
            'book_id' => $book->id,
            'rented_at' => Carbon::now(),
            'due_at' => Carbon::now()->addWeeks(2),
        ]);

        // Act: Attempt to rent the same book
        $response =$this->withHeader('Authorization', "Bearer {$this->token}")->postJson('/api/v1/rentals', [
            'book_id' => $book->id,
            'user_id' => 1,
        ]);

        // Assert: Check the response for error
        $response->assertStatus(400)
                 ->assertJson(['error' => 'This book is already rented.']);
    }


  

    public function test_successfully_retrieves_rental_history()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
    
        Rental::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    
        $this->rentalRepository->shouldReceive('getHistory')->once()->with($user->id)
            ->andReturn(Rental::all());

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")->getJson("/api/v1/rentals/history?user_id={$user->id}");
        $response->assertStatus(200)
                 ->assertJsonStructure([['id', 'user_id', 'book_id', 'rented_at', 'due_at', 'is_overdue']]);
    }
    
}
