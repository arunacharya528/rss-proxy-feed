<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class GuardianResponseData extends Data
{
    public function __construct(
        public string $id,
        public string $type,
        public string $sectionId,
        public string $sectionName,
        public string $webPublicationDate,
        public string $webTitle,
        public string $webUrl,
        public string $apiUrl,
        public string $isHosted,
        public string $pillarId,
        public string $pillarName
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
