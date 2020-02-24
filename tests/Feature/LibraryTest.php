<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class LibraryTest extends TestCase
{
    use RefreshDatabase;

    /* Database Test Begin*/
    /** @test */
    public function databaseAbleToAddABookTest()
    {
        $book = factory(Book::class)->create();

        $this->assertDatabaseHas('books', [
            'id' => $book->id
        ]);
    }
    /* Database Test End */

    /* Create A Book Test Begin */
    /** @test */
    public function userAbleToAddABookTest()
    {
        // This is a store action.
        $response = $this->post('/book', [
            'title' => 'Learning Laravel',
            'author' => 'Mohammed Salah',
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Learning Laravel',
            'author' => 'Mohammed Salah',
        ]);

        $response->assertRedirect('/book');
    }
    /** @test */
    public function userAbleToAddABookWithOnlyAuthorAndTitleFieldsTest()
    {
        $response = $this->post('/book', [
            'BADVALUE' => 'BAD',
            'title' => 'Learning Laravel',
            'author' => 'Mohammed Salah',
        ]);

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
    public function disallowEmptyDataFromAddingToTheBooksDatabaseTest()
    {
        $response = $this->post('/book', [
            'title' => '',
            'author' => 'Mohammed Salah',
        ]);

        $this->assertDatabaseMissing('books', [
            'title' => '',
            'author' => 'Mohammed Salah',
        ]);

        $response->assertSessionHasErrors(['title',]);
    }
    /* Create A Book Test End */

    /* Update A Book Test Begin */
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
    /** @test */
    public function disallowEmptyDataFromModifyingTheBooksDatabaseTest()
    {
        $book = factory(Book::class)->create();

        $response = $this->patch('/book/' . $book->id, [
            'author' => '',
        ]);

        $this->assertDatabaseMissing('books', [
            'author' => '',
        ]);

        $response->assertSessionHasErrors(['author',]);

    }
    /* Update A Book Test End */

    /* Delete A Book Test Begin */
       /** @test */
    public function deleteABookFromTheBooksDatabaseTest()
    {
        $book = factory(Book::class)->create();

        $response = $this->delete('/book/' . $book->id);

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);

        $response->assertRedirect('/book');

    }
    /* Delete A Book Test End */
    
    /* Search By Title Or Author Test Begin */
    /** @test */
    public function userCanSearchBooksByAuthorFromTheBooksDatabaseTest()
    {
        $title = "AI";

        $book = factory(Book::class, 50)->create();

        $bookToSearch = factory(Book::class)->create([
                'title' => $title,
                'author' => "MoSalah",
        ]);

        $response = $this->get('/book/search?query=' . $title);
        $response->assertSeeText($title);
    }
    /** @test */
    public function userCanSearchBooksByTitleFromTheBooksDatabaseTest()
    {
        $author = "MoSalah";

        $book = factory(Book::class, 50)->create();

        $bookToSearch = factory(Book::class)->create([
                'title' => 'AI',
                'author' => $author,
        ]);

        $response = $this->get('/book/search?query=' . $author);
        $response->assertSeeText($author);
    }
    /* Search By Title Or Author Test End */

    /* Sort By Title Or Author Test Begin */
    /** @test */
    public function listSortByTitleDESCWorksCorrectlyTest()
    {
        factory(Book::class, 5)->create();

        $bookToSearch = factory(Book::class)->create([
                'title' => 'ZZZLAST',
                'author' => "ZZZLAST",
        ]);

        $response = $this->get('/book?sort=title&direction=desc&page=1');
        $response->assertSeeText('ZZZLAST');
    }
    /** @test */
    public function listSortByTitleASCWorksCorrectlyTest()
    {
        factory(Book::class, 5)->create();

        $bookToSearch = factory(Book::class)->create([
                'title' => 'ZZZLAST',
                'author' => "ZZZLAST",
        ]);

        $response = $this->get('/book?sort=title&direction=asc&page=2');
        $response->assertSeeText('ZZZLAST');
    }
    /* Sort By Title Or Author Test End */
}