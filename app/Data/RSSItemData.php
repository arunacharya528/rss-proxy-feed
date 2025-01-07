<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class RSSItemData extends Data
{
    public function __construct(
        public string $title,
        public string $link,
        public string|Optional $description,
        public string|Optional $enclosure,
        public string $pubDate,
        public string $guid,
    ) {}
}
