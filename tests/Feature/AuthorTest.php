<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show()
    {
        $token = $this->getAccessToken();
        $id = 1;

        $this->json('GET', "/api/authors/$id/books", [], ['Accept' => 'application/json', 'Authorization' => "Bearer $token"])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    "id",
                    "name",
                    'books' => [
                        [
                            'title',
                            'authors' => [
                                [
                                    'id',
                                    'name',
                                ]
                            ]
                        ]
                    ]
                ],
            ]);
    }



    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store()
    {
        $token = $this->getAccessToken();
        $name = Str::random(10);

        $body = [
            'name' => $name,
        ];

        $this->json('POST', "/api/authors", $body, ['Accept' => 'application/json', 'Authorization' => "Bearer $token"])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'books',
                ],
            ]);
    }
}
