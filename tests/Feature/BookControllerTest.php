<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->token = $user->createToken('API Token')->plainTextToken;
    }

    /** @test */
    public function it_fetches_the_list_of_books_with_valid_bearer_token(): void
    {
        // Create dummy books
        Book::factory()->count(3)->create();

        // Make the GET request with the Bearer token
        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
                         ->getJson('/api/v1/books');

        // Assert the response status and structure
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                 ]);

        // Assert the data structure (make sure that at least 3 books are returned)
        $this->assertCount(3, $response->json('data'));
    }

    /** @test */
    public function it_returns_500_when_an_exception_is_thrown(): void
    {
        $this->mock(\App\Repositories\BookRepository::class, function ($mock) {
            $mock->shouldReceive('all')->andThrow(new \Exception('Failed to fetch books'));
        });

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
                         ->getJson('/api/v1/books');

        // Assert the response status is 500 and the error message is as expected
        $response->assertStatus(500)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Failed to fetch books',
                 ]);
    }

    public function test_successfully_searches_for_books()
    {
        // Arrange: Create some books in the database
        Book::factory()->create(['title' => 'Laravel Testing']);
        Book::factory()->create(['title' => 'PHP Unit Testing']);

        // Act: Simulate a search request
        $response = $this->withHeader('Authorization', "Bearer {$this->token}")->getJson('/api/v1/books/search?search=Laravel');

        // Assert: Check the response
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         [
                             'id' => 1,
                             'title' => 'Laravel Testing',
                         ],
                     ],
                 ]);
    }

  
}
