<?php


namespace Wandxx\Payment\Providers;


use Illuminate\Support\ServiceProvider;
use Wandxx\Payment\Contracts\PaymentRepositoryContract;
use Wandxx\Payment\Repositories\PaymentRepository;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(PaymentEventServiceProvider::class);
    }

    public function boot(): void
    {
        $this->_publishing();
        $this->_bindRepository();
    }

    private function _publishing(): void
    {
        $this->publishes([
            __DIR__ . "/../Migrations" => database_path("migrations")
        ], "migrations");
    }

    private function _bindRepository(): void
    {
        $this->app->bind(PaymentRepositoryContract::class, PaymentRepository::class);
    }
}