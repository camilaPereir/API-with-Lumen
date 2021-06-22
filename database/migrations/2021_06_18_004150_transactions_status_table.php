<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransactionsStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("status", function (Blueprint $blueprint) {

            $blueprint->id();
            $blueprint->string("status");
            $blueprint->unsignedBigInteger("transaction_id");
            $blueprint->timestamps();

            $blueprint->foreign("transaction_id")->references("id")->on("transaction");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("status");
    }
}
