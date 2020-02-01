<?php


namespace Wandxx\Payment\Models;


use Envant\Fireable\FireableAttributes;
use Illuminate\Database\Eloquent\Model;
use Wandxx\Payment\Constants\PaymentStatus;
use Wandxx\Payment\Events\PaymentDone;
use Wandxx\Payment\Events\PaymentFailed;
use Wandxx\Payment\Events\PaymentOnProgress;
use Wandxx\Support\Traits\UuidForKey;

class Payment extends Model
{
    use UuidForKey, FireableAttributes;

    protected $guarded = ["id"];
    public $incrementing = false;
    protected $casts = [
        "metadata" => "array"
    ];
    protected $fireableAttributes = [
        "status" => [
            PaymentStatus::ON_PROGRESS => PaymentOnProgress::class,
            PaymentStatus::DONE => PaymentDone::class,
            PaymentStatus::FAILED => PaymentFailed::class
        ]
    ];

    public function logs()
    {
        return $this->hasMany(PaymentLog::class);
    }
}