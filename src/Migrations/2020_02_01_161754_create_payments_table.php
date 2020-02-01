<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid("user_id");
            $table->uuid("transaction_id");
            $table->string("code")->unique();
            $table->integer("unique_amount")->default(0);
            $table->bigInteger("amount",false);
            $table->bigInteger("paid",false)->default(0);
            $table->bigInteger("total",false);
            $table->unsignedTinyInteger("status");
            $table->dateTime("expired_at")->nullable();
            $table->json("metadata")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
