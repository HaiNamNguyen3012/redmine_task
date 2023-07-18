<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanUserBoughtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_user_boughts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('plan_id')->nullable();
            $table->integer('price')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('charge_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_user_boughts');
    }
}
