<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliticsTable extends Migration
{
    /**
     * nome do politico
     *
     * @return void
     */
    public function up()
    {
        Schema::create('politics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('id')->on('people');
            $table->string('slug',150)->unique();//slug of person    
            $table->unsignedBigInteger('political_office_id');//cargo politico
            $table->foreign('political_office_id')->references('id')->on('political_offices');
            $table->unsignedBigInteger('political_party_id');//partido politico
            $table->foreign('political_party_id')->references('id')->on('political_parties');      
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
        Schema::dropIfExists('politics');
    }
}
