<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class GuardianResponseData extends Data
{
    public function __construct(
        public string|Optional $id,
        public string|Optional $type,
        public string|Optional $sectionId,
        public string|Optional $sectionName,
        public string|Optional $webPublicationDate,
        public string|Optional $webTitle,
        public string|Optional $webUrl,
        public string|Optional $apiUrl,
        public string|Optional $isHosted,
        public string|Optional $pillarId,
        public string|Optional $pillarName
    ) {}

    public function getRssData(): RSSItemData
    {
        return RSSItemData::from([
            'title' => $this->webTitle,
            'link' => $this->webUrl,
            'pubDate' => (new Carbon($this->webPublicationDate))->format(config('panel.rss_date_time_format_for_carbon')),
            'guid' => $this->webUrl,
        ]);
    }
}
