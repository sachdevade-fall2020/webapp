<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class UnauthorizedTest extends TestCase
{
    /**
     * Unauthorized request test.
     *
     * @return void
     */
    public function testProtectedApi()
    {
        $response = $this->json('GET', route('user.get'));

        $response->assertUnauthorized();
    }
}
