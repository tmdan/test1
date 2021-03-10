<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Support\Str;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $token = $this->getAccessToken();

        $this->json('GET', '/api/books', [], ['Accept' => 'application/json', 'Authorization' => "Bearer $token"])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'title',
                        'authors' => [
                            [
                                'id',
                                'name',
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
    public function test_show()
    {
        $token = $this->getAccessToken();

        $id = 1;

        $this->json('GET', "/api/books/$id", [], ['Accept' => 'application/json', 'Authorization' => "Bearer $token"])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'title',
                    'authors' => [
                        [
                            'id',
                            'name',
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
        $author = Author::find(1);
        $title = Str::random(10);

        $body = [
            'title' => $title,
            'author_ids' => [$author->id]
        ];

        $this->json('POST', "/api/books", $body, ['Accept' => 'application/json', 'Authorization' => "Bearer $token"])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => $title,
                    'authors' => [
                        [
                            'id' => 1,
                            'name' => $author->name,
                        ]
                    ]
                ],
            ]);
    }
}
