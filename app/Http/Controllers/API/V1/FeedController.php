<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use Spatie\ArrayToXml\ArrayToXml;

class FeedController extends Controller
{
    public function index($service)
    {
        $feeds = NewsService::init()->setParams(['q' => $service])->getData();

        $rssResponse = [
            'channel' => [
                'title' => 'Some title',
                'item' => $feeds['response']['results'],
            ],
        ];

        $xml = ArrayToXml::convert($rssResponse, rootElement: 'rss');

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
