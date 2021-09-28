<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentClassActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_class_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->unsignedBigInteger('class_material_id');
            $table->foreign('class_material_id')->references('id')->on('class_materials');
            $table->unsignedBigInteger('course_class_id');
            $table->foreign('course_class_id')->references('id')->on('course_classes');
            $table->boolean('clicked')->default(0);
            $table->tinyInteger('downloaded')->default(0);
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
        Schema::dropIfExists('student_class_activities');
    }
}
