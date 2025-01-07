<?php

use App\Http\Middleware\LogRequestAndResponse;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
    'namespace' => '\\App\\Http\\Controllers\\API\\V1',
    'as' => 'api.v1.',
    'middleware' => [LogRequestAndResponse::class],
], function () {
    Route::get('/{section}', 'FeedController@index')->name('feeds.index');
});
