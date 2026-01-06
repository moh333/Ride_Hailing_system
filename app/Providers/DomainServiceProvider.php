<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Trip\Repositories\TripRepositoryInterface;
use App\Infrastructure\Persistence\Repositories\EloquentTripRepository;
use App\Domain\Trip\Services\PricingServiceInterface;
// We need a concrete implementation for PricingService.
// I'll create a basic one inline or bind a mock for now.

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            TripRepositoryInterface::class,
            EloquentTripRepository::class
        );

        // Binding a simple inline PricingService for now
        $this->app->bind(PricingServiceInterface::class, function () {
            return new class implements PricingServiceInterface {
                public function calculatePrice(\App\Domain\Shared\ValueObjects\Location $origin, \App\Domain\Shared\ValueObjects\Location $destination): float
                {
                    return max(10.0, $origin->distanceTo($destination) * 1.5); // $1.5 per km, min $10
                }
            };
        });
    }

    public function boot(): void
    {
        //
    }
}
