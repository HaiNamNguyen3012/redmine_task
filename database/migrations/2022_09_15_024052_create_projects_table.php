<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('details')->nullable();
            $table->boolean('task_backend')->default(0);
            $table->boolean('task_frontend')->default(0);
            $table->boolean('task_design')->default(0);
            $table->boolean('task_server')->default(0);
            $table->boolean('task_mobile')->default(0);
            $table->boolean('task_tablet')->default(0);
            $table->boolean('task_other')->default(0);
            $table->integer('is_active')->default(0)->comment('0: not active,1 active,2 block');
            $table->integer('creator')->default(0)->comment('account created project = user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
