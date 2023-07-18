<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('name')->nullable();
            $table->text('details')->nullable();
            $table->string('category_name')->nullable();
            $table->string('priority')->nullable();
            $table->string('status')->nullable();
            $table->string('version')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->integer('creator')->nullable()->comment('account created task = user_id');
            $table->timestamps();
            $table->index(['project_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
