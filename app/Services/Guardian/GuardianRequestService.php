<?php

namespace App\Services\Guardian;

use App\Data\GuardianResponseData;
use App\Services\Abstract\AbstractNewsService;
use Illuminate\Http\Client\Response;
use Spatie\LaravelData\DataCollection;

/**
 * Service to fetch data from guardian's API Service
 *
 * @throws \Exception
 *
 * @see https://open-platform.theguardian.com/documentation/search
 */
class GuardianRequestService extends AbstractNewsService
{
    /**
     * @var array<string>
     */
    public array $additionalParameters = [];

    public function getUri(): string
    {
        return config('guardian.news_url').'/search';
    }

    public function getParameters(): array
    {
        return [
            'api-key' => config('guardian.api_key'),
            ...$this->additionalParameters,
        ];
    }

    /**
     * Method to set additional parameter to the guardian request
     *
     * @param  array<string>  $params
     */
    public function setAdditionalParameters(array $params): static
    {
        $this->additionalParameters = $params;

        return $this;
    }

    public function exceptions(Response $response)
    {
        if ($response->getStatusCode() === 401) {
            throw new \Exception('Missing keys for API call');
        }

        $response->onError(function () {
            throw new \Exception('Error occurred during API request');
        });
    }

    public function formatResponse(): DataCollection
    {
        return GuardianResponseData::collect($this->response->json()['response']['results'], DataCollection::class);
    }
}
