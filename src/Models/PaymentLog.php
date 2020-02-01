<?php


namespace Wandxx\Payment\Models;


use Illuminate\Database\Eloquent\Model;
use Wandxx\Support\Traits\UuidForKey;

class PaymentLog extends Model
{
    use UuidForKey;

    protected $guarded = ["id"];
    public $incrementing = false;

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}