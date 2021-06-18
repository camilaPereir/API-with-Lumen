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
        Schema::create("users", function ($blueprint) {

            $blueprint->id();
            $blueprint->string("name");
            $blueprint->string("email")->unique();
            $blueprint->string("cpf_cnpj")->unique();
            $blueprint->string("password");
            $blueprint->string("user_type_id");
            $blueprint->string("wallet_id");
            $blueprint->timestamps();
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
