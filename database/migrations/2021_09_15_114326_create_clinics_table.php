<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->increments('clinic_id');
            $table->string('clinic_name');
            $table->string('owner_name');
            $table->bigInteger('clinic_mobile');
            $table->string('clinic_email');
            $table->bigInteger('clinic_tel')->nullable();
            $table->string('clinic_blk')->nullable();
            $table->string('clinic_street')->nullable();
            $table->string('clinic_barangay')->nullable();
            $table->string('clinic_city');
            $table->string('clinic_zip');
            $table->tinyInteger('clinic_isActive')->default(1);
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
        Schema::dropIfExists('clinics');
    }
}
