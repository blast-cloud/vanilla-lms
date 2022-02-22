<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassMaterialsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('lecture_number')->nullable();
            $table->integer('assignment_number')->nullable();
            $table->timestamp('due_date')->nullable();;
            $table->string('blackboard_meeting_id')->nullable();
            $table->string('blackboard_meeting_status')->nullable();
            $table->string('upload_file_path')->nullable();;
            $table->string('upload_file_type')->nullable();;
            $table->string('reference_material_url')->nullable();;
            $table->integer('course_class_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('course_class_id')->references('id')->on('course_classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('class_materials');
    }
}
