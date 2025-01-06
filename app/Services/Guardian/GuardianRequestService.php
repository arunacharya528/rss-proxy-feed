<?php

namespace App\Services\Guardian;

use App\Services\Interface\NewsServiceInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Service to fetch data from guardian's API Service
 */
class GuardianRequestService implements NewsServiceInterface
{
    /**
     * Summary of getData
     *
     * @param  array  $params  Parameters to get data for the feed [See Attached link]
     *
     * @throws \Exception
     *
     * @see https://open-platform.theguardian.com/documentation/search
     */
    public static function getData(array $params): Response
    {
        $response = Http::withUrlParameters([
            'endpoint' => config('guardian.news_url'),
            'api-key' => config('guardian.api_key'),
            'parameters' => http_build_query($params),
        ])->get('{+endpoint}/?api-key={api-key}&{parameters}');

        if ($response->getStatusCode() === 401) {
            throw new \Exception('Missing keys for API call');
        }

        $response->onError(function () {
            throw new \Exception('Error occurred during API request');
        });

        return $response;
    }
}
