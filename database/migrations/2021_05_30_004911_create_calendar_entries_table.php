<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarEntriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->date('due_date');
            $table->text('description');
            $table->integer('course_class_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('course_class_id')->references('id')->on('course_classes');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('calendar_entries');
    }
}
