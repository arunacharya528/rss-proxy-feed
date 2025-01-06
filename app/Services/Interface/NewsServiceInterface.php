<?php

namespace App\Services\Interface;

use Illuminate\Http\Client\Response;

interface NewsServiceInterface
{
    public static function getData(array $params): Response;
}
