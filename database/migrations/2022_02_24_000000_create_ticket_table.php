<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable();
            $table->string('name')->nullable();
            $table->string('sex')->nullable();
            $table->date('birthday')->nullable();
            $table->string('adult_ticket')->nullable();
            $table->string('young_ticket')->nullable();
            $table->string('location')->nullable();
            $table->string('area')->nullable();
            $table->date('ticketing_date')->nullable();
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
        Schema::dropIfExists('ticket');
    }
}
