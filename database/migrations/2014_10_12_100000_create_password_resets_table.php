<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')                 ->unique();
            $table->string('password_reset_token')  ->unique();
            $table->timestamp('created_at');    //if current time is more than 3 days of reset request, then it is invalid also
            $table->tinyInteger('is_valid');    //if email link is clicked, then it will become invalid

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
        Schema::drop('password_resets');
    }
}
