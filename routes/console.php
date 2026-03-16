<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Ping the app every 14 minutes to prevent Render free-tier spin-down
Schedule::call(function () {
    Http::timeout(10)->get(config('app.url') . '/ping');
})->cron('*/14 * * * *');
