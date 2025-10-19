<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Laravel;

use RohanAdhikari\NepaliDate\NepaliDate;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $timezone = config('app.timezone', 'Asia/Kathmandu');
        NepaliDate::setDefaultTimeZoneName($timezone);
    }
}
