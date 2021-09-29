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
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students');
            $table->integer('class_material_id')->unsigned();
            $table->foreign('class_material_id')->references('id')->on('class_materials');
            $table->integer('course_class_id')->unsigned();
            $table->foreign('course_class_id')->references('id')->on('course_classes');
            $table->boolean('clicked')->default(0);
            $table->boolean('downloaded')->default(0);
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
        Schema::enableForeignKeyConstraints();
    }
}
