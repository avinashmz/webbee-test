<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\EventRepositoryInterface;
use App\Repository\Eloquent\EventRepository;
use App\Repository\BookingRepositoryInterface;
use App\Repository\Eloquent\BookingRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\CustomerRepositoryInterface;
use App\Repository\Eloquent\CustomerRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
