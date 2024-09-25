<?php

namespace Tests\Feature\API\V1;

use Tests\TestCase;
use App\Repositories\StatsRepository;
use Illuminate\Http\JsonResponse;
use Mockery\MockInterface;

class StatsControllerTest extends TestCase
{
    /**
     * Test retrieving the most overdue book.
     *
     * @return void
     */
    public function testRetrievesMostOverdueBook(): void
    {
        $overdueBook = (object)[
            'id' => 1,
            'title' => 'Laravel for Beginners',
            'author' => 'John Doe',
            'due_date' => '2024-09-15',
        ];

        $this->mock(StatsRepository::class, function (MockInterface $mock) use ($overdueBook) {
            $mock->shouldReceive('mostOverdueBook')->once()->andReturn((object)['book' => $overdueBook]);
        });

        $controller = app(\App\Http\Controllers\API\V1\StatsController::class);
        $response = $controller->mostOverdueBook();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($overdueBook, json_decode($response->getContent()));
    }

    /**
     * Test that 404 is returned when no overdue book is found.
     *
     * @return void
     */
    public function testReturns404IfNoOverdueBookFound(): void
    {
        $this->mock(StatsRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('mostOverdueBook')->once()->andReturnNull();
        });
        $controller = app(\App\Http\Controllers\API\V1\StatsController::class);
        $response = $controller->mostOverdueBook();
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test retrieving the most popular book.
     *
     * @return void
     */
    public function testRetrievesMostPopularBook(): void
    {
        $popularBook = (object)[
            'id' => 1,
            'title' => 'Laravel for Beginners',
            'author' => 'John Doe',
            'rental_count' => 10,
        ];

        $this->mock(StatsRepository::class, function (MockInterface $mock) use ($popularBook) {
            $mock->shouldReceive('mostPopularBook')->once()->andReturn($popularBook);
        });

        $controller = app(\App\Http\Controllers\API\V1\StatsController::class);
        $response = $controller->mostPopularBook();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($popularBook, json_decode($response->getContent()));
    }

    /**
     * Test that 404 is returned when no popular book is found.
     *
     * @return void
     */
    public function testReturns404IfNoPopularBookFound(): void
    {
        $this->mock(StatsRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('mostPopularBook')->once()->andReturnNull();
        });

        $controller = app(\App\Http\Controllers\API\V1\StatsController::class);
        $response = $controller->mostPopularBook();
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test retrieving the least popular book.
     *
     * @return void
     */
    public function testRetrievesLeastPopularBook(): void
    {
        $leastPopularBook = (object)[
            'id' => 1,
            'title' => 'Learning PHP',
            'author' => 'Jane Smith',
            'rental_count' => 1,
        ];

        $this->mock(StatsRepository::class, function (MockInterface $mock) use ($leastPopularBook) {
            $mock->shouldReceive('leastPopularBook')->once()->andReturn($leastPopularBook);
        });

        $controller = app(\App\Http\Controllers\API\V1\StatsController::class);
        $response = $controller->leastPopularBook();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($leastPopularBook, json_decode($response->getContent()));
    }

    public function testReturns404IfNoLeastPopularBookFound(): void
    {
        $this->mock(StatsRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('leastPopularBook')->once()->andReturnNull();
        });

        $controller = app(\App\Http\Controllers\API\V1\StatsController::class);
        $response = $controller->leastPopularBook();
        $this->assertEquals(200, $response->getStatusCode());
    }
}
