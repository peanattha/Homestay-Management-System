<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomestaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homestays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homestay_type_id')->references('id')->on('homestay_types')->onDelete('cascade');
            $table->string('homestay_name');
            $table->char('status',1);
            $table->string('homestay_img', 10240);
            $table->string('homestay_detail', 512);
            $table->float('homestay_price');
            $table->integer('number_guests');
            $table->integer('num_bedroom');
            $table->integer('num_bathroom');
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
        Schema::dropIfExists('homestays');
    }
}
