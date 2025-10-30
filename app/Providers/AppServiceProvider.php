<?php

namespace App\Providers;

use App\Domain\Booking\Contracts\BookingRepository;
use App\Domain\Guides\Contracts\GuideRepository;
use App\Repositories\Eloquent\BookingRepositoryEloquent;
use App\Repositories\Eloquent\GuideRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(
            BookingRepository::class,
            BookingRepositoryEloquent::class
        );

        $this->app->bind(
            GuideRepository::class,
            GuideRepositoryEloquent::class
        );
    }
}
