<?php


namespace Wandxx\Payment\Services;


use Illuminate\Database\Eloquent\Model;
use Wandxx\Payment\Contracts\PaymentRepositoryContract;

class UserPaymentService
{
    private $_paymentRepository;
    private $_guard;
    public $payment;

    public function __construct(PaymentRepositoryContract $_paymentRepository, Model $payment, string $_guard)
    {
        $this->payment = $payment;
        $this->_paymentRepository = $_paymentRepository;
        $this->_guard = $_guard;
    }

    public function updateStatus(int $status, ?string $failedMessage): Model
    {
        return $this->_paymentRepository->updatePaymentStatus($status, $this->payment, $failedMessage);
    }

    public function isExpired(): bool
    {
        $user = auth($this->_guard)->id();
        $paymentId = $this->payment->id;

        return $this->_paymentRepository->isPaymentExpired($paymentId, $user);
    }
}