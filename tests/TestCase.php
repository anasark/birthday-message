<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->insertGeo();
        $this->createUser();
    }

    public function insertGeo()
    {
        Artisan::call('db:seed', ['--class' => 'GeoSeeder']);
    }

    public function createUser($total = 1)
    {
        User::factory()->count($total)->createQuietly([
            'birth_date' => date('Y-m-d')
        ]);
    }

    /**
     * @return void
     */
    public function bootApplicationManually(): void
    {
        $this->refreshApplication();
    }

    /**
     * @param TestResponse $response
     * @param integer      $statusCode
     * @param boolean      $isSuccess
     *
     * @return array
     */
    public function verifyAndDecode(TestResponse $response, int $statusCode = 200, bool $isSuccess = true): array
    {
        $responseContent = $response->getContent();
        $decodedData     = json_decode($responseContent, true);

        $response->assertStatus($statusCode);
        $this->assertJson($responseContent);
        $this->assertEquals($statusCode, $response['status']);
        $this->assertEquals($isSuccess, $response['success']);

        return $decodedData;
    }
}
