<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class UserGetTest extends TestCase
{
    /** @test */
    public function index(): void
    {
        $response = $this->get('/api/user');

        $dataResponse = $this->verifyAndDecode($response);

        $this->assertEquals(true, $dataResponse['success']);
    }

    /** @test */
    public function getUser(): void
    {
        $response = $this->get('/api/user/1');

        $dataResponse = $this->verifyAndDecode($response);

        $this->assertEquals(true, $dataResponse['success']);
        $this->assertArrayHasKey('data', $dataResponse);
        $this->assertArrayHasKey('first_name', $dataResponse['data']);
        $this->assertArrayHasKey('last_name', $dataResponse['data']);
        $this->assertArrayHasKey('birth_date', $dataResponse['data']);
    }

    /** @test */
    public function getUserFailed(): void
    {
        $response = $this->get('/api/user/2');

        $dataResponse = $this->verifyAndDecode($response, 404, false);

        $this->assertEquals([
            'code'    => 2001,
            'message' => 'Not found',
        ], $dataResponse['error']);
    }
}
