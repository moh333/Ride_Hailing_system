<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Trip\Repositories\TripRepositoryInterface;
use App\Infrastructure\Persistence\Repositories\EloquentTripRepository;
use App\Domain\Driver\Repositories\DriverRepositoryInterface;
use App\Infrastructure\Persistence\Repositories\EloquentDriverRepository;
use App\Domain\Passenger\Repositories\PassengerRepositoryInterface;
use App\Infrastructure\Persistence\Repositories\EloquentPassengerRepository;
use App\Domain\Trip\Services\PricingServiceInterface;
use App\Domain\Pricing\Services\PricingCalculator;
use App\Domain\Pricing\ValueObjects\Tariff;
use App\Domain\Shared\ValueObjects\Location;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repositories
        $this->app->bind(
            TripRepositoryInterface::class,
            EloquentTripRepository::class
        );

        $this->app->bind(
            DriverRepositoryInterface::class,
            EloquentDriverRepository::class
        );

        $this->app->bind(
            PassengerRepositoryInterface::class,
            EloquentPassengerRepository::class
        );

        // Domain Services
        // Here we adapt the Pricing Domain to the Trip Domain's Interface
        $this->app->bind(PricingServiceInterface::class, function ($app) {
            return new class ($app->make(PricingCalculator::class)) implements PricingServiceInterface {
                public function __construct(private PricingCalculator $calculator)
                {
                }

                public function calculatePrice(Location $origin, Location $destination): float
                {
                    // Use standard tariff for now
                    return $this->calculator->calculate(
                        $origin,
                        $destination,
                        Tariff::standard()
                    );
                }
            };
        });
    }

    public function boot(): void
    {
        //
    }
}
