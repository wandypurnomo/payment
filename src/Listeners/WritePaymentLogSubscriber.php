<?php


namespace Wandxx\Payment\Listeners;


use Illuminate\Events\Dispatcher;
use Wandxx\Payment\Events\PaymentDone;
use Wandxx\Payment\Events\PaymentFailed;
use Wandxx\Payment\Events\PaymentOnProgress;

class WritePaymentLogSubscriber
{
    public function writeLog($event)
    {
        $payment = $event->model;

        $data = [
            "payment_id" => $payment->id,
            "description" => sprintf("changed to %s", "haha"),
            "status" => $payment->status,
        ];

        $payment->logs()->create($data);
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen([
            PaymentOnProgress::class,
            PaymentDone::class,
            PaymentFailed::class
        ], "Wandxx\Payment\Listeners\WritePaymentLogSubscriber@writeLog");
    }
}