<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_name_id')->references('id')->on('bank_names')->onDelete('cascade');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('acc_number');
            $table->char('prompt_pay',12);
            $table->string('qr_code', 10240);
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
        Schema::dropIfExists('bank_admins');
    }
}
