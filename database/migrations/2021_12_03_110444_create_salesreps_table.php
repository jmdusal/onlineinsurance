<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesrepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesreps', function (Blueprint $table) {
            $table->id();
            $table->string('salesrep_name');
            $table->integer('salesrep_num');
            $table->string('commission_percent');
            $table->string('tax_rate');
            $table->decimal('bonus', 5, 2)->nullable();
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
        Schema::dropIfExists('salesrep');
    }
}
