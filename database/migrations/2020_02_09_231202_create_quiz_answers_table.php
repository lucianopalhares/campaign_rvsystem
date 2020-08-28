<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('quiz_campaign_id');
            $table->foreign('quiz_campaign_id')->references('id')->on('quiz_campaigns');
            $table->unsignedBigInteger('quiz_question_id');
            $table->foreign('quiz_question_id')->references('id')->on('quiz_questions');
            //answered_times: vezes que foi respondida esta questao com esta campanha
            $table->string('description')->nullable();
            //pode nao ter opções se na tabela 'quiz_questions' for 0 na coluna 'options_required'
            $table->unsignedBigInteger('quiz_option_id')->nullable();
            $table->foreign('quiz_option_id')->references('id')->on('quiz_options');
            $table->string('quiz_option_description')->nullable();
            $table->string('name',150)->nullable();//nome de quem respondeu
            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts');
            $table->string('address')->nullable()->default('Não Respondeu');
            $table->string('zip_code')->nullable()->default('Não Respondeu');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('quiz_answers');
    }
}
