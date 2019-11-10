<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class bookReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', [
            'title' => 'Cool book title',
            'author' => 'Chris'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());

//        make sure we redirect to book that we created
        $response->assertRedirect($book->path());
    }

    /**
     * @test
     */
    public function a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Chris'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function an_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'cool title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /**
     * @test
     */
    public function a_book_can_be_updated()
    {
        $this->post('/books', [
            'title' => 'cool title',
            'author' => 'chris'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(),[
            'title' => 'New title',
            'author' => 'New author'
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New author', Book::first()->author);

//        make sure we redirect to the book
        $response->assertRedirect($book->fresh()->path());
    }

    /**
     * @test
     */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
//        creating book to test
        $this->post('/books', [
            'title' => 'cool title',
            'author' => 'chris'
        ]);

        $book = Book::first();
//        make sure we pass data before testing
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());

//        make sure we redirect to index page
        $response->assertRedirect('/books');

    }
}
