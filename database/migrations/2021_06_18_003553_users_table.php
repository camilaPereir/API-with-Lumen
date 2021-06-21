<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users", function (Blueprint $blueprint) {

            $blueprint->id();
            $blueprint->string("name");
            $blueprint->string("email")->unique();
            $blueprint->string("cpf_cnpj")->unique();
            $blueprint->string("password");
            $blueprint->unsignedBigInteger("type_id");
            $blueprint->unsignedBigInteger("wallet_id");
            $blueprint->timestamps();

            $blueprint->foreign("type_id")->references("id")->on("type")->onDelete("cascade");
            $blueprint->foreign("wallet_id")->references("id")->on("wallet")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("users");
    }
}
