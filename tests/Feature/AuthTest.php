<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\Generator\Generator;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $this->json('POST', '/api/login', self::CREDENTIALS, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
               'access_token',
               'type',
            ]);
    }
}
