<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            // description OU quiz_optionable (apenas um dos dois deve ser preenchido)
            $table->text('description')->nullable();
            //quiz_questionable pode ser politic_id, city_id etc
            $table->integer('quiz_optionable_id')->nullable();// id
            $table->string('quiz_optionable_type')->nullable();// path/model  
            $table->string('quiz_optionable_name')->nullable();// relation ex: collum_id          
            $table->unsignedBigInteger('quiz_campaign_id');//campanha desta opção
            $table->foreign('quiz_campaign_id')->references('id')->on('quiz_campaigns');
            $table->unsignedBigInteger('quiz_question_id');// questão desta opção
            $table->foreign('quiz_question_id')->references('id')->on('quiz_questions');
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
        Schema::dropIfExists('quiz_options');
    }
}
