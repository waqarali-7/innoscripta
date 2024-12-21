<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule the news:fetch command
Schedule::command('news:fetch')->hourly()
    ->appendOutputTo(storage_path('logs/news_fetch.log'));
