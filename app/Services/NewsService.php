<?php

namespace App\Services;

use App\Services\Abstract\AbstractNewsService;
use App\Services\Guardian\GuardianRequestService;
use Illuminate\Support\Facades\Cache;

class NewsService
{
    /**
     * Currently active news service
     *
     * @var AbstractNewsService|string
     */
    public string $serviceClass;

    /**
     * Parameters for this service
     *
     * @var array<string>
     */
    public array $params;

    /**
     * Initialize this service
     *
     * @param  mixed  $serviceClass  The name of the class to get service from
     * @return NewsService
     */
    public static function init($serviceClass = GuardianRequestService::class)
    {
        $service = new static;

        $service->serviceClass = $serviceClass;

        return $service;
    }

    /**
     * Set parameters
     *
     * @param  array<string>  $params
     * @return static
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Get key to store data in cache
     */
    public function cacheKey(): string
    {
        return $this->serviceClass.'&'.http_build_query($this->params);
    }

    /**
     * Fetch data from currently active news service
     *
     * @return mixed
     */
    public function getData(): array
    {
        if (Cache::has($this->cacheKey())) {
            return Cache::get($this->cacheKey());
        }

        $guardianFeeds = GuardianRequestService::make()
            ->setAdditionalParameters($this->params)
            ->sendRequest()
            ->formatResponse();

        $rssData = $guardianFeeds->map(fn ($feed) => $feed->getRssData())->toArray();

        Cache::put($this->cacheKey(), $rssData, now()->addMinutes(config('panel.news_cache_invalidation_in_minutes')));

        return $rssData;
    }
}
