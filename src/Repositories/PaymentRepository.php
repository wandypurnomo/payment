<?php


namespace Wandxx\Payment\Repositories;


use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Wandxx\Payment\Constants\PaymentStatus;
use Wandxx\Payment\Contracts\PaymentRepositoryContract;
use Wandxx\Payment\Events\PaymentCreated;
use Wandxx\Payment\Models\Payment;
use Wandxx\Support\Traits\FindableTrait;

class PaymentRepository implements PaymentRepositoryContract
{
    use FindableTrait;

    private $_model;

    public function __construct(Payment $_model)
    {
        $this->_model = $_model;
    }

    public function all(Request $request, ?string $userId, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->_model->newQuery();

        $where = function (Builder $builder) use ($request, $userId) {
            if (!is_null($userId)) {
                $builder->where("user_id", $userId);
            }

            if ($request->has("transaction") && $request->get("transaction") != "") {
                $builder->where("transaction_id", $request->get("transaction"));
            }

            if ($request->has("status") && $request->get("status") != "") {
                $status = (int)$request->get("status");
                $builder->where("status", $status);
            }

            if ($request->has("expired") && $request->get("expired") != "") {
                $expired = (int)$request->get("expired");
                if ($expired == 1) {
                    $builder->whereDate("expired_at", "<=", Carbon::now());
                }
            }
        };

        $query->where($where);
        return $query->paginate($perPage);
    }

    public function createPayment(array $data, string $userId): Model
    {
        $data["user_id"] = $userId;
        $model = $this->_model->newQuery()->create($data);
        event(new PaymentCreated($model));
        return $model;
    }

    public function updatePaymentStatus(int $status, Model $payment, ?string $failedMessage): Model
    {
        throw_if($status == PaymentStatus::FAILED && is_null($failedMessage), new BadRequestHttpException());

        $model = $payment;

        if ($status == PaymentStatus::FAILED) {
            $model->update(["status" => $status, "metadata->failed_message" => $failedMessage]);
        } else {
            $model->update(["status" => $status]);
        }

        return $model;
    }

    public function isPaymentExpired(string $paymentId, string $userId): bool
    {
        return $this->_model->newQuery()
            ->where("user_id", $userId)
            ->where("id", $paymentId)
            ->whereDate("expired_at", ">", Carbon::now())
            ->exists();
    }

    public function setExpired(): void
    {
        $this->_model->newQuery()
            ->whereDate("expired_at", ">", Carbon::now())
            ->update(["expired_at" => Carbon::now()]);
    }
}