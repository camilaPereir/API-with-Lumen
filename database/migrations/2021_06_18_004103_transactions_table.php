<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("transaction", function (Blueprint $blueprint) {

            $blueprint->id();
            $blueprint->unsignedBigInteger("payee");
            $blueprint->unsignedBigInteger("payer");
            $blueprint->decimal("value");
            $blueprint->timestamps();

            $blueprint->foreign("payee")->references("id")->on("users")->onDelete("cascade");
            $blueprint->foreign("payer")->references("id")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("transaction");
    }
}
