<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    /** @test */
    public function update(): void
    {
        $user = User::create([
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'address'    => 'bourke street',
            'city'       => 'melbourne',
            'country'    => 'australia',
            'birth_date' => '2024-01-24',
            'timezone'   => 'Australia/Melbourne',
            'email'      => 'john.doe@mail.com'
        ]);

        $data = [
            'city'    => 'Semarang',
            'country' => 'Indonesia',
        ];
    
        $response = $this->put('/api/user/' . $user->id, $data);

        $dataResponse = $this->verifyAndDecode($response);

        $user->refresh();

        $this->assertEquals(true, $dataResponse['success']);
        $this->assertEquals($data['city'], $user->city);
        $this->assertEquals($data['country'], $user->country);
        $this->assertEquals($user->timezone, 'Asia/Jakarta');
    }

    /** @test */
    public function updateInvalid(): void
    {
        $data = [
            'city'    => null,
            'country' => 'Indonesia',
        ];

        $response = $this->put('/api/user/1', $data);

        $dataResponse = $this->verifyAndDecode($response, 422, false);

        $this->assertEquals([
            'code'                => 2002,
            'message'             => 'The city field must be a string.',
            'validation_messages' => [
                'The city field must be a string.',
            ]
        ], $dataResponse['error']);
    }

    /** @test */
    public function updateFailed(): void
    {
        $response = $this->put('/api/user/2', []);

        $dataResponse = $this->verifyAndDecode($response, 404, false);

        $this->assertEquals([
            'code'    => 2001,
            'message' => 'Not found',
        ], $dataResponse['error']);
    }
}
