<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBroadcastNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broadcast_notifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->boolean('admin_receives')->default(0);
            $table->boolean('managers_receives')->default(0);
            $table->boolean('lecturers_receives')->default(0);
            $table->boolean('students_receives')->default(0);
            $table->boolean('broadcast_status')->default(0);
            $table->integer('semester_id')->unsigned();
            $table->date('scheduled_date')->nullable();
            $table->time('scheduled_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table("broadcast_notifications", function(Blueprint $table) {
            $table->foreign('semester_id')->references('id')->on('semesters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('broadcast_notifications');
        Schema::enableForeignKeyConstraints();
    }
}
