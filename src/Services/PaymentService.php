<?php


namespace Wandxx\Payment\Services;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Wandxx\Payment\Contracts\PaymentRepositoryContract;

class PaymentService
{
    private $_paymentRepository;
    private $_guard;

    public function __construct(PaymentRepositoryContract $_paymentRepository)
    {
        $this->_paymentRepository = $_paymentRepository;
        $this->_guard = "user";
    }

    public function setGuard(string $guard): PaymentService
    {
        $this->_guard = $guard;
        return $this;
    }

    public function all(Request $request, ?string $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->_paymentRepository->all($request, $userId, $perPage);
    }

    public function createPayment(array $data): Model
    {
        $user = auth($this->_guard)->id();
        $this->_paymentRepository->createPayment($data, $user);
    }

    public function getPayment(string $paymentId): UserPaymentService
    {
        $payment = $this->_paymentRepository->find($paymentId);
        return new UserPaymentService($this->_paymentRepository, $payment, $this->_guard);
    }
}