<?php

namespace App\Providers;

use App\Contracts\SortInterface;
use App\Services\Sorting\BubbleSortService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SortInterface::class, BubbleSortService::class);
    }

    public function boot(): void
    {
        //
    }
}
