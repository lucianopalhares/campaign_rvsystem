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
            $table->integer('answered_times')->nullable()->default(1);
            $table->string('description')->nullable();
            //pode nao ter opções se na tabela 'quiz_questions' for 0 na coluna 'options_required'
            $table->unsignedBigInteger('quiz_option_id')->nullable();
            $table->foreign('quiz_option_id')->references('id')->on('quiz_options');
            $table->unsignedBigInteger('quiz_option_id2')->nullable();//uma segunda opção como resposta
            $table->foreign('quiz_option_id2')->references('id')->on('quiz_options');
            $table->unsignedBigInteger('quiz_option_id3')->nullable();//uma terceira opção como resposta
            $table->foreign('quiz_option_id3')->references('id')->on('quiz_options');            
            $table->string('name',150)->nullable();//nome de quem respondeu
            $table->enum('sex',['F','M','Não Respondeu'])->nullable()->default('Não Respondeu');
            $table->enum('years_old',[
              '16-24 Anos',
              '25-34 Anos',
              '35-44 Anos',
              '45-59 Anos',
              'Acima de 60 Anos',
              'Não Respondeu'
              ])->nullable()->default('Não Respondeu');
            $table->enum('salary',[
              'Até 1 Salário Minimo',
              'Entre 1 e 2 Salários Minimos',
              'Entre 2 e 5 Salários Minimos',
              'Entre 5 e 10 Salários Minimos',
              'Mais de 10 Salários Minimos',
              'Não Respondeu'
              ])->nullable()->default('Não Respondeu');
            $table->enum('education_level',[
              'Ensino Fundamental / Incompleto',
              'Ensino Fundamental / Completo',
              'Ensino Médio / Incompleto',
              'Ensino Médio / Completo',
              'Nunca Estudou',
              'Superior / Incompleto',
              'Superior / Completo',
              'Não Respondeu'
              ])->nullable()->default('Não Respondeu');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
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
