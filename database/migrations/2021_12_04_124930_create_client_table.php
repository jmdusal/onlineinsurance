<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->bigIncrements('client_id');
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->decimal('client_commission', 5, 2);
            $table->unsignedbigInteger('payroll_id')->nullable();
            $table->foreign('payroll_id')->references('payroll_id')->on('payroll')->onDelete('CASCADE');
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
        Schema::dropIfExists('client');
    }
}
