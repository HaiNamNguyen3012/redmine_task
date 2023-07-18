<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentServiceProductIdToPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->string('payment_service_product_id')->after('project_quantity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('payment_service_product_id');
        });
    }
}
