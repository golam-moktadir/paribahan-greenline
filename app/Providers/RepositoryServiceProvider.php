<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\DriverRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\BoothRepository;
use App\Repositories\GuideRepository;
use App\Repositories\CityRepository;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\DriverRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\BoothRepositoryInterface;
use App\Repositories\Interfaces\GuideRepositoryInterface;
use App\Repositories\Interfaces\OffenceRepositoryInterface;
use App\Repositories\Interfaces\StationRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\OffenceRepository;
use App\Repositories\StationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            EmployeeRepositoryInterface::class,
            EmployeeRepository::class
        );

        $this->app->bind(
            DriverRepositoryInterface::class,
            DriverRepository::class
        );

        $this->app->bind(
            GuideRepositoryInterface::class,
            GuideRepository::class
        );

        $this->app->bind(
            OffenceRepositoryInterface::class,
            OffenceRepository::class
        );

        $this->app->bind(
            BoothRepositoryInterface::class,
            BoothRepository::class
        );

        $this->app->bind(
            StationRepositoryInterface::class,
            StationRepository::class
        );

        $this->app->bind(
            CityRepositoryInterface::class,
            CityRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
