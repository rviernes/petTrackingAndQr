<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('customer_id');
            $table->string('customer_fname');
            $table->string('customer_lname');
            $table->string('customer_mname')->nullable();
            $table->bigInteger('customer_mobile');
            $table->bigInteger('customer_tel');
            $table->string('customer_gender');
            $table->date('customer_birthday');
            $table->string('customer_DP')->nullable();
            $table->string('customer_blk')->nullable();
            $table->string('customer_street')->nullable();
            $table->string('customer_subdivision')->nullable();
            $table->string('customer_city');
            $table->integer('id');
            $table->tinyInteger('customer_isActive')->default(1);
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
        Schema::dropIfExists('customers');
    }
}
