<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll', function (Blueprint $table) {
            $table->bigIncrements('payroll_id');
            $table->string('date_period');
            $table->decimal('payroll_bonus', 5, 2);
            $table->unsignedbigInteger('salesrep_id')->nullable();
            $table->foreign('salesrep_id')->references('salesrep_id')->on('salesrep')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('payroll');
    }
}
