<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUser()
    {
        $response = $this->json('POST', route('user.create'), [
            'first_name'    => 'Testing',
            'last_name'     => 'User',
            'email_address' => 'testinguser@mail.com',
            'password'      => 'P@ssw0rd123'
        ]);

        $response->assertStatus(201);
    }
}
