<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('permission_id')->nullable();
            $table->timestamps();
            $table->index(['project_id', 'user_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_permissions');
    }
}
