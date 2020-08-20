<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSQuizOptionsTable extends Migration
{
    /**
     * modelo de opção
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_quiz_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('description');
            //pertence a algum modelo de questao? 
            $table->unsignedBigInteger('s_quiz_question_id')->nullable();
            $table->foreign('s_quiz_question_id')->references('id')->on('s_quiz_questions');
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
