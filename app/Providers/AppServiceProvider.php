<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
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
        // Set default timezone to Indian Standard Time
        date_default_timezone_set(config('app.timezone', 'Asia/Kolkata'));
        Carbon::setTestNow(Carbon::now(config('app.timezone', 'Asia/Kolkata')));
    }
}
