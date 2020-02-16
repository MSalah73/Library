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
    public function userAbleToAddABookWithOnlyAuthorAndTitleFieldsTest()
    {
        // This is a store action.
        $response = $this->post('/book', [
            'BADVALUE' => 'BAD',
            'title' => 'Learning Laravel',
            'author' => 'Mohammed Salah',
        ]);
        // $response->assertStatus(200);

        $this->assertDatabaseHas('books', [
            'title' => 'Learning Laravel',
            'author' => 'Mohammed Salah',
        ]);

        $this->assertDatabaseMissing('books', [
            'BADVALUE' => 'BAD',
        ]);

        $response->assertRedirect('/book');
    }
        /** @test */
    public function userAbleToAddABookTest()
    {
        // This is a store action.
        $response = $this->post('/book', [
            'title' => 'Learning Laravel',
            'author' => 'Mohammed Salah',
        ]);
        // $response->assertStatus(200);

        $this->assertDatabaseHas('books', [
            'title' => 'Learning Laravel',
            'author' => 'Mohammed Salah',
        ]);

        $response->assertRedirect('/book');
    }
    /** @test */
    public function userAbleToModifyAuthorsNameTest()
    {
        $book = factory(Book::class)->create();

        $response = $this->patch('/book/' . $book->id, [
            'author' => 'Mohammed Salah Modified',
        ]);

        $this->assertDatabaseHas('books', [
            'title' => $book->title,
            'author' => 'Mohammed Salah Modified',
        ]);

        $response->assertRedirect('/book');

    }
    /** @test */
    public function userAbleToModifyAuthorsNameAndNothingElse()
    {
        $book = factory(Book::class)->create();

        $response = $this->patch('/book/' . $book->id, [
            'SHELLCODE' => 'DEADBEEF',
            'title' => 'Bad Title',
            'author' => 'Mohammed Salah Modified',
        ]);
        
        $this->assertDatabaseHas('books', [
            'title' => $book->title,
            'author' => 'Mohammed Salah Modified',
        ]);

        $this->assertDatabaseMissing('books', [
            'SHELLCODE' => 'DEADBEEF',
        ]);

        $response->assertRedirect('/book');
    }
}