<?php

return [
    'rss' => [
        'title' => config('app.name'),
        'description' => env('APP_DESCRIPTION', '-'),
    ],
    'news_cache_invalidation_in_minutes' => env('NEWS_CACHE_INVALIDATION_IN_MINUTES', 10),
    'rss_date_time_format_for_carbon' => 'D, d M Y H:i:s O',
];
