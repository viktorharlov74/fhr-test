<?php

namespace App\Providers;

use App\Contracts\ExportServiceInterface;
use App\Contracts\PersonRepositoryInterface;
use App\Contracts\SortInterface;
use App\Contracts\DataFileServiceInterface;
use App\Repositories\PersonRepository;
use App\Services\Export\ExportService;
use App\Services\Sorting\BubbleSortService;
use App\Services\Sorting\DataFileService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SortInterface::class, BubbleSortService::class);

        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
        $this->app->bind(ExportServiceInterface::class, ExportService::class);
        $this->app->bind(DataFileServiceInterface::class, DataFileService::class);
    }

    public function boot(): void
    {
        //
    }
}
