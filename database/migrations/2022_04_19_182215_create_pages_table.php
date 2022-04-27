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
        Schema::create('pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 200)->unique();
            $table->string('slug', 200)->unique();
            $table->string('author_id')->nullable();
            $table->text('body');
            $table->boolean('is_root_page')->nullable()->unique();
            $table->boolean('is_published')->default(0);
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')
                ->onDelete('cascade')
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
        Schema::dropIfExists('pages');
    }
};
