<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeterinariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veterinaries', function (Blueprint $table) {
            $table->increments('vet_id');
            $table->string('vet_fname');
            $table->string('vet_lname');
            $table->string('vet_mname')->nullable();
            $table->bigInteger('vet_mobile');
            $table->bigInteger('vet_tel');
            $table->date('vet_birthday');
            $table->string('vet_DP')->nullable();
            $table->string('vet_blk')->nullable();
            $table->string('vet_street')->nullable();
            $table->string('vet_subdivision')->nullable();
            $table->string('vet_barangay')->nullable();
            $table->string('vet_city');
            $table->integer('vet_zip');
            $table->integer('id');
            $table->integer('clinic_id');
            $table->date('vet_dateAdded');
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
        Schema::dropIfExists('veterinaries');
    }
}
