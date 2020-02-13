<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSQuizQuestionsTable extends Migration
{
    /**
     * modelo de questão
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_quiz_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('description');
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
        Schema::dropIfExists('s_quiz_questions');
    }
}
