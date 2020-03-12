<?php


namespace Wandxx\Payment\Contracts;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Wandxx\Support\Interfaces\FindableInterface;

interface PaymentRepositoryContract extends FindableInterface
{
    public function all(Request $request, ?string $userId, int $perPage = 10): LengthAwarePaginator;

    public function createPayment(array $data, string $userId): Model;

    public function updatePaymentStatus(int $status, Model $payment, ?string $failedMessage): Model;

    public function isPaymentExpired(string $paymentId, string $userId): bool;

    public function setExpired(): void;
}