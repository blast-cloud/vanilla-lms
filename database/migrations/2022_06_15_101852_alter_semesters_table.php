<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("semesters", function(Blueprint $table) {
            $table->boolean('is_current')->default(0);
            $table->string('academic_session');
            $table->boolean('status')->default(0);
            $table->string('unique_code')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->dropColumn('is_current');
            $table->dropColumn('academic_session');
            $table->dropColumn('status');
            $table->dropColumn('unique_code');
        });
    }
}
