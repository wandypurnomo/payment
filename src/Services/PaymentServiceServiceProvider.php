<?php


namespace Wandxx\Payment\Services;


use Carbon\Laravel\ServiceProvider;
use Wandxx\Payment\Contracts\PaymentRepositoryContract;

class PaymentServiceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind("paymentService", function () {
            return new PaymentService(resolve(PaymentRepositoryContract::class));
        });
    }
}