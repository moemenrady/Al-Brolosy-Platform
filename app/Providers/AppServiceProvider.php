<?php

namespace App\Providers;

use App\Services\ClientHistoryService;
use App\Services\ClientService;
use App\Services\ConsultationService;
use App\Services\ContractService;
use App\Services\PaymentService;
use App\Services\ReservationService;
use App\Services\SmartCardService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ClientService::class, fn () => new ClientService());
        $this->app->singleton(SmartCardService::class, fn () => new SmartCardService());
        $this->app->singleton(ClientHistoryService::class, fn () => new ClientHistoryService());
        $this->app->singleton(ConsultationService::class, fn () => new ConsultationService());
        $this->app->singleton(ReservationService::class, fn () => new ReservationService());
        $this->app->singleton(ContractService::class, fn () => new ContractService());
        $this->app->singleton(PaymentService::class, fn () => new PaymentService());
    }

    public function boot(): void
    {
        //
    }
}
