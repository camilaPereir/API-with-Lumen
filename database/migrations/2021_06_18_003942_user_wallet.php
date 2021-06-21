<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserWallet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("wallet", function (Blueprint $blueprint) {

            $blueprint->id();
            $blueprint->unsignedBigInteger("id_users");
            $blueprint->decimal("value")->default(100.00);
            $blueprint->timestamps();

            $blueprint->foreign("id_users")->references("id")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("wallet");
    }
}
