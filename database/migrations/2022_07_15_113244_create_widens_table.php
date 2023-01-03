<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appliance_id')->references('id')->on('appliances')->onDelete('cascade');
            $table->foreignId('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->integer('amount');
            $table->float('price');
            $table->string('winden_by');
            $table->char('status',1);
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
        Schema::dropIfExists('widens');
    }
}
