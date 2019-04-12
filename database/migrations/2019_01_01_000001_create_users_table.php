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
            $table->string('email', 255)->unique();
            $table->string('password',255);
            $table->string('token', 255);
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('image', 255)->default('default');
            $table->string('extension', 50)->default('png');
            $table->string('address', 255)->nullable();
            $table->string('post_code', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('profession', 255)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_factored')->default(false);
            $table->boolean('is_confirmed')->default(false);
            $table->unsignedInteger('role_id');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
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
