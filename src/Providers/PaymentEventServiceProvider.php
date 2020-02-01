<?php


namespace Wandxx\Payment\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Wandxx\Payment\Listeners\WritePaymentLogSubscriber;

class PaymentEventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        WritePaymentLogSubscriber::class
    ];
}