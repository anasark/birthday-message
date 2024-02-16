<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class UserStoreTest extends TestCase
{
    /** @test */
    public function store(): void
    {
        $data = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'address'    => 'bourke street',
            'city'       => 'melbourne',
            'country'    => 'australia',
            'birth_date' => '2024-01-24',
            'timezone'   => 'Australia/Melbourne',
            'email'      => 'john.doe@mail.com'
        ];

        $response = $this->post('/api/user', $data);

        $data['birth_date'] = $data['birth_date'] . ' 00:00:00';

        $this->verifyAndDecode($response, 201);
        $this->assertDatabaseHas('users', $data);
    }

    /** @test */
    public function storeInvalid(): void
    {
        $data = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'address'    => 'bourke street',
            'city'       => 'melbourne',
            'country'    => 'australia',
            'timezone'   => 'Australia',
            'email'      => 'john.doe@mail.com'
        ];

        $response = $this->post('/api/user', $data);

        $dataResponse = $this->verifyAndDecode($response, 422, false);

        $this->assertEquals([
            'code'                => 2002,
            'message'             => 'The birth date field is required. (and 1 more error)',
            'validation_messages' => [
                'The birth date field is required.',
                'The selected timezone is invalid.',
            ]
        ], $dataResponse['error']);
    }
}
