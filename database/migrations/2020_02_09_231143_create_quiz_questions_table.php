<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizQuestionsTable extends Migration
{
    /**
     * questão
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('description');
            //quiz_questionable pode ser politic_id, city_id etc, complementa a descrição
            $table->integer('quiz_questionable_id')->nullable();// id
            $table->string('quiz_questionable_type')->nullable();// path/model
            $table->string('quiz_questionable_name')->nullable();// relation ex: collum_id
            $table->unsignedBigInteger('quiz_campaign_id');
            $table->foreign('quiz_campaign_id')->references('id')->on('quiz_campaigns');
            $table->integer('options_required')->nullable()->default(0);//vai ter opções?
            $table->integer('type')->nullable()->default(0);
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
        Schema::dropIfExists('quiz_questions');
    }
}
