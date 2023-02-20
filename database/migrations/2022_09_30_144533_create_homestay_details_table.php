<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomestayDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homestay_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appliance_id')->references('id')->on('appliances')->onDelete('cascade');
            $table->foreignId('homestay_id')->references('id')->on('homestays')->onDelete('cascade');
            $table->integer('amount');
            $table->string('widen_by');
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
        Schema::dropIfExists('homestay_details');
    }
}
