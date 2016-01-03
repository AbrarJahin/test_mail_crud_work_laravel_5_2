<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table)
        {
            $table->integer('user_id')                                  ->unsigned()  ->index();
            $table->enum('status', ['debit', 'credit']) ->default('debit'); //debit = +, credit = -
            $table->enum('transection_by', ['user', 'admin', 'system']) ->default('system'); //System = auto redused by corn job
            $table->timestamps();

            //Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payments');
    }
}
