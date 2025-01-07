<?php

namespace Tests\Feature;

use App\Data\GuardianResponseData;
use App\Services\Guardian\GuardianRequestService;
use Tests\TestCase;

class GuardianRequestServiceTest extends TestCase
{
    public function test_api_keys_must_be_passed_to_get_response(): void
    {
        $this->expectException(\Exception::class);

        config(['guardian.api_key' => null]);

        GuardianRequestService::make()->sendRequest();
    }

    public function test_can_search_data(): void
    {
        $response = GuardianRequestService::make()->setAdditionalParameters(['q' => 'Movies'])->sendRequest()->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_will_return_array_of_data_transfer_objects_as_response(): void
    {
        $data = GuardianRequestService::make()->setAdditionalParameters(['q' => 'Movies'])->sendRequest()->formatResponse();

        foreach ($data as $row) {
            $this->assertInstanceOf(GuardianResponseData::class, $row);
        }
    }
}
