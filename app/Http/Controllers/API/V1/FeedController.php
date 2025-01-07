<?php

namespace App\Http\Controllers\API\V1;

use App\Data\RssFeedData;
use App\Http\Controllers\Controller;
use App\Services\NewsService;
use Spatie\ArrayToXml\ArrayToXml;

class FeedController extends Controller
{
    public function index($service)
    {
        $feeds = NewsService::init()->setParams(['q' => $service])->getData();

        $rssFeed = new RssFeedData(
            config('panel.rss.title'),
            config('panel.rss.description'),
            config('app.url'),
            config('app.locale'),
            now()->format(config('panel.rss_date_time_format_for_carbon'))
        );

        $xml = ArrayToXml::convert([
            'channel' => [
                ...$rssFeed->toArray(),
                '__custom:atom\\:link:1' => [
                    '_attributes' => [
                        'href' => request()->fullUrl(),
                        'rel' => 'self',
                        'type' => 'application/rss+xml',
                    ],
                ],
                ...['item' => $feeds],
            ],
        ], [
            'rootElementName' => 'rss',
            '_attributes' => [
                'version' => '2.0',
                'xmlns:atom' => 'http://www.w3.org/2005/Atom',
            ],
        ], options: ['formatOutput' => true]);

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
