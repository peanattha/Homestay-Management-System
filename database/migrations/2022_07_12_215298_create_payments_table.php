<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_admin_id')->nullable()->references('id')->on('bank_admins')->onDelete('cascade');
            $table->foreignId('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->char('payment_type',1);
            $table->string('slip_img', 10240)->nullable();
            $table->float('total_price');
            $table->float('pay_price')->nullable();
            $table->float('change')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
