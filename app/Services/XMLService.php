<?php

namespace App\Services;

use App\Data\RssFeedData;
use Spatie\ArrayToXml\ArrayToXml;

class XMLService
{
    public array $data = [];

    public static function build()
    {
        $service = new static;

        return $service;
    }

    public function setRssData(array $feedItems)
    {
        $rssFeed = new RssFeedData(
            config('panel.rss.title'),
            config('panel.rss.description'),
            config('app.url'),
            config('app.locale'),
            now()->format(config('panel.rss_date_time_format_for_carbon'))
        );

        $this->data = [

            'channel' => [
                ...$rssFeed->toArray(),
                '__custom:atom\\:link:1' => [
                    '_attributes' => [
                        'href' => request()->fullUrl(),
                        'rel' => 'self',
                        'type' => 'application/rss+xml',
                    ],
                ],
                ...['item' => $feedItems],
            ],

        ];

        return $this;
    }

    public function getXML()
    {
        return ArrayToXml::convert(
            $this->data,
            [
                'rootElementName' => 'rss',
                '_attributes' => [
                    'version' => '2.0',
                    'xmlns:atom' => 'http://www.w3.org/2005/Atom',
                ],
            ]
        );
    }
}
