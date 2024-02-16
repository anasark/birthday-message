<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class UserDeleteTest extends TestCase
{
    /** @test */
    public function deleteUser(): void
    {
        $response = $this->delete('/api/user/1');

        $dataResponse = $this->verifyAndDecode($response);

        $this->assertEquals(true, $dataResponse['success']);
        $this->assertSoftDeleted('users', ['id' => 1]);
    }

    /** @test */
    public function deleteFailed(): void
    {
        $response = $this->delete('/api/user/2');

        $dataResponse = $this->verifyAndDecode($response, 404, false);

        $this->assertEquals([
            'code'    => 2001,
            'message' => 'Not found',
        ], $dataResponse['error']);
    }
}
