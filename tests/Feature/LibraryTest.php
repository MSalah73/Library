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
        $book = factory(Book::class)->make();
        $this->assertDatabaseHas('book', $book);
    }
}
