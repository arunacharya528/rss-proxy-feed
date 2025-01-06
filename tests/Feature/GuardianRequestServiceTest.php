<?php

namespace Tests\Feature;

use App\Services\Guardian\GuardianRequestService;
use Tests\TestCase;

class GuardianRequestServiceTest extends TestCase
{
    public function test_api_keys_must_be_passed_to_get_response(): void
    {
        $this->expectException(\Exception::class);

        config(['guardian.api_key' => null]);

        $response = GuardianRequestService::getData(['q' => 'Movies']);
    }

    public function test_can_search_data(): void
    {
        $response = GuardianRequestService::getData(['q' => 'Movies']);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
