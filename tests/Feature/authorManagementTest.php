<?php

namespace Tests\Feature;

use \App\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class authorManagementTest extends TestCase
{

    use RefreshDatabase;
    /**
     * @test
     */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->post('/author', [
            'name' => 'Author name',
            'dob' => '05/13/1992'
            ]);

        $author =  Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1992/05/13', $author->first()->dob->format('Y/m/d'));
    }
}
