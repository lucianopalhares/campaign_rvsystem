<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('cpf',25)->unique();
            $table->enum('sex',['F','M']);
            $table->string('slug',150)->unique();
            $table->string('nickname',20)->nullable();           
            $table->integer('years_old')->nullable();
            $table->datetime('birth')->nullable();
            $table->string('salary',20)->nullable();
            $table->enum('education_level',[
              'Ensino Fundamental / Incompleto',
              'Ensino Fundamental / Completo',
              'Ensino Médio / Incompleto',
              'Ensino Médio / Completo',
              'Nunca Estudou',
              'Superior / Incompleto',
              'Superior / Completo',
              ])->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('people');
    }
}
