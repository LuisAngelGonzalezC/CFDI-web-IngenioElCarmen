<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->unique();
            $table->string('name');
            $table->string('last_name');
            $table->string('second_last_name');
            $table->string('rfc');
            $table->string('curp');
            $table->string('imss');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->boolean('type')->default(false);
            $table->boolean('confirmed')->default(false);
            $table->string('confirmation_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
