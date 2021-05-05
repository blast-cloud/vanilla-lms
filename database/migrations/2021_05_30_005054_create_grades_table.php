<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('grade_title');
            $table->integer('score');
            $table->string('grade_letter');
            $table->integer('student_id')->unsigned();
            $table->integer('course_class_id')->unsigned();
            $table->integer('class_material_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('course_class_id')->references('id')->on('course_classes');
            $table->foreign('class_material_id')->references('id')->on('class_materials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grades');
    }
}
