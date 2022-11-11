<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('homestay_id')->references('id')->on('homestays')->onDelete('cascade');
            $table->foreignId('set_menu_id')->references('id')->on('set_menus')->onDelete('cascade');
            $table->foreignId('promotion_id')->nullable()->references('id')->on('promotions')->onDelete('cascade');
            $table->char('booking_type',1);
            $table->date('start_date');
            $table->date('end_date');
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->string('check_in_by')->nullable();
            $table->string('check_out_by')->nullable();
            $table->integer('number_guests');
            $table->integer('num_menu');
            $table->float('total_price');
            $table->float('total_price_discount')->nullable();
            $table->float('discount')->nullable();
            $table->float('deposit');
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
        Schema::dropIfExists('bookings');
    }
}
