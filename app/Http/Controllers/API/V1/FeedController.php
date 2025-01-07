<?php

namespace App\Http\Controllers\API\V1;

use App\Data\RSSItemData;
use App\Http\Controllers\Controller;
use App\Services\NewsService;
use App\Services\XMLService;

class FeedController extends Controller
{
    public function index($service)
    {
        $xmlService = XMLService::build();

        // Pattern to check the validity of incoming query
        $pattern = '/^(?=.*[a-z].*[a-z])(?=.*[a-z]$)[a-z-]+$/';

        if (! preg_match($pattern, $service)) {
            $xml = $xmlService->setRssData([
                RSSItemData::from([
                    'title' => 'Error: Invalid Query',
                    'link' => request()->fullUrl(),
                    'description' => 'The provided service query is invalid. Please make sure the query is lowercase with hyphens if applicable.',
                    'pubDate' => now()->format(config('panel.rss_date_time_format_for_carbon')),
                    'guid' => request()->fullUrl(),
                ])->toArray(),
            ])->getXML();

            return response($xml, 422)->header('Content-Type', 'application/xml');
        }

        $feeds = NewsService::init()->setParams(['q' => $service])->getData();

        $xml = $xmlService->setRssData($feeds)->getXML();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
