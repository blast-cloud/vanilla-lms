<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseClassFeedbacks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_class_feedbacks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id'); 
            $table->text('note')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('department_id')->unsigned();
            $table->integer('course_class_id')->unsigned();
            $table->bigInteger('creator_user_id')->unsigned();

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('creator_user_id')->references('id')->on('users');
            $table->foreign('course_class_id')->references('id')->on('course_classes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_class_feedbacks');
    }
}
