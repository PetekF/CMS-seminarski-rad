<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 50)->unique()->index();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 50)->unique()->index();
            $table->string('password', 100);
            $table->string('role_id')->nullable();
            $table->rememberToken();
            $table->tinyInteger('login_attempts')->unsigned()->default(0);
            $table->timestamps();
            $table->dateTime('email_verified_at')->nullable();

            $table->foreign('role_id')->references('id')->on('roles')
                //->onDelete()
                ->onUpdate('cascade');
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
};
