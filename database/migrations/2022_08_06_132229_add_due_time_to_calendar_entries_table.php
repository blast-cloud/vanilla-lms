<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDueTimeToCalendarEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendar_entries', function (Blueprint $table) {
            //
            $table->time('due_time')->nullable();
            $table->string('due_day')->nullable();
            $table->date('due_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendar_entries', function (Blueprint $table) {
            // 
            $table->dropColumn('due_time');
            $table->dropColumn('due_day');
            $table->dropColumn('due_date');
        });
    }
}
