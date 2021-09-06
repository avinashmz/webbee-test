<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('open_date')->comment('Event Open Date')->nullable();
            $table->timestamp('close_date')->comment('Event Close Date')->nullable();
            $table->tinyInteger('booking_per_slot')->default(5);
            $table->tinyInteger('slot_duration')->default(30);
            $table->tinyInteger('future_day_max')->default(5)->comment('Define number of days upto which user can book for a event in future.');
            $table->tinyInteger('minimum_time_gap')->default('10')->comment('Minimum time gap required in minutes to book an event.');
            $table->string('day_start')->comment('Day Start for an Event Day')->default('08:00')->nullable();
            $table->string('day_end')->comment('Day End for an Event Day')->default('20:00')->nullable();
            $table->string('break_start')->comment('Break Start for an Event Day')->default('12:00')->nullable();
            $table->string('break_end')->comment('Break End for an Event Day')->default('13:00')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
