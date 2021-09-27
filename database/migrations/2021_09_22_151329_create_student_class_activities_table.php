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
            $table->unsignedBigInteger('class_material_id');
            $table->unsignedBigInteger('course_class_id');
            $table->boolean('clicked')->default(0);
            $table->tinyInteger('downloaded')->default(0);
            $table->timestamps();

            $table->index('student_id');
            $table->foreign('student_id')->refrences('id')->on('students');
            $table->index('class_material_id');
            $table->foreign('class_material_id')->refrences('id')->on('class_materials');
            $table->index('course_class_id');
            $table->foreign('course_class_id')->refrences('id')->on('course_classes');
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
