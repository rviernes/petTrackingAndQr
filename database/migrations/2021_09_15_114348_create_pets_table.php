<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->increments('pet_id');
            $table->string('pet_name');
            $table->string('pet_gender');
            $table->string('pet_birthday');
            $table->string('pet_notes')->nullable();
            $table->string('pet_bloodType')->nullable();
            $table->string('pet_DP')->nullable();
            $table->date('pet_registeredDate');
            $table->integer('pet_type_id');
            $table->integer('pet_breed_id');
            $table->integer('customer_id');
            $table->integer('clinic_id');
            $table->tinyInteger('pet_isActive')->default(1);
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
        Schema::dropIfExists('pets');
    }
}
