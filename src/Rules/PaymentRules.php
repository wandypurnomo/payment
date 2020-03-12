<?php


namespace Wandxx\Payment\Rules;


class PaymentRules
{
    public static function createPayment(): array
    {
        return [
            'user_id' => 'required',
            'transaction_id' => 'required',
            'paid' => 'required|numeric'
        ];
    }
}