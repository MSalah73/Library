<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;


class LibraryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function databaseAbleToAddABookTest()
    {
        $book = factory(Book::class)->create();

        $this->assertDatabaseHas('books', [
            'id' => $book->id
        ]);
    }
    /** @test */
    public function userAbleToAddABookTest()
    {
        // This is a store action.
        $response = $this->post('/book', [
            'title' => 'Learning Laravel',
            'author' => 'Mohammed Salah',
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('books', [
            'title' => 'Learning Laravel',
            'author' => 'Mohammed Salah',
        ]);
    }
}