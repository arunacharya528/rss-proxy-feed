<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class RssFeedData extends Data
{
    public function __construct(
        public string $title,
        public string $description,
        public string $link,
        public string $language,
        public string $pubDate,
    ) {}
}
