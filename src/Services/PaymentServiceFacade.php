<?php


namespace Wandxx\Payment\Services;


use Illuminate\Support\Facades\Facade;

class PaymentServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'paymentService';
    }
}