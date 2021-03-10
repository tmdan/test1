<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const CREDENTIALS = [
        'email' => 'admin@mail.ru',
        'password' => 'asdasd',
    ];


    public function getAccessToken()
    {
        return  $this->json('POST', '/api/login', self::CREDENTIALS, ['Accept' => 'application/json'])
            ->assertStatus(200)->json('access_token');
    }
    
}
