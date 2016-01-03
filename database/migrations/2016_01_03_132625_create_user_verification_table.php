<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVerificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_verification', function (Blueprint $table)
        {
            $table->string('email')                 ->unique();
            $table->string('verification_token')    ->unique();
            $table->timestamps();

            //Foreign Keys
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_verification', function (Blueprint $table)
        {
            Schema::drop('user_verification');
        });
    }
}
