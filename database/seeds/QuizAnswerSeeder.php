<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Domain\Quiz\Model\QuizCampaign;
use App\Domain\City\Model\District;

class QuizAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fichas = 500;//quantidade de respostas para cada pergunta
        
        $campaign = QuizCampaign::find(1);
        
        $first_names = [
          ['first_name'=>'Adriano'],
          ['first_name'=>'Sandra'],
          ['first_name'=>'Mateus'],
          ['first_name'=>'Carla'],
          ['first_name'=>'Manoel'],
          ['first_name'=>'Andressa'],
          ['first_name'=>'Lucas'],
          ['first_name'=>'Marilene'],
          ['first_name'=>'Benicio'],
          ['first_name'=>'Rute'],
        ];
        $middle_names =[
          'Souza','Alencar','Rosa','Oliveira','Pereira','Magalhães'
        ];
        $last_names =[
          'Santana','Dias','Rodrigues','Ferreira','Bretas','Reis'
        ];                           

        $districts =  @json_decode(json_encode(District::whereCityId(2342)->orWhere('city_id',null)->get()), true);
                                                    
        foreach ($campaign->questions as $question) {
          
          $fichas_restantes = $fichas;
          
          if($question->options_required=='1'){
            
            $qtdeOpcoes = $question->options->count();
          
            foreach ($question->options as $option) {
                                              
              $dividedAll = $fichas_restantes/$qtdeOpcoes;// 100 / 9 = 11.11
              $restDivided = $fichas_restantes-$dividedAll;// 100 - 11.11 = 88
              $restDividedMinus = $restDivided/$qtdeOpcoes; // 88/9 = 9.87
              
              $dividedAllWithMinus = $dividedAll+$restDividedMinus;// 11.11 + 9.87 = 20.98 *
              $fichas_restantes = $fichas_restantes-$dividedAllWithMinus; 
              
              $a = 1;
              while ($a <= $dividedAllWithMinus) {                             
                $a++;

                $first_name = Arr::random($first_names);
                $middle_name = Arr::random($middle_names);
                $last_name = Arr::random($last_names);
                
                $name = $first_name['first_name'].' '.$middle_name.' '.$last_name;             
                                                          
                $option_id = $option->id;
                                
                $district = Arr::random($districts);
                $district_id = $district['id'];

                DB::table('quiz_answers')->insert([
                    'quiz_campaign_id' => 1,
                    'quiz_question_id' => $question->id,
                    'description' => '',
                    'quiz_option_id' => $option_id,
                    'name' => $name,          
                    'district_id' => $district_id,
                    'address' => 'Rua Teste, Nº 999',
                    'zip_code' => '99999-999',
                ]);                              
              }  
            }  
        }//if($question->options_required=='1'){
      }
    }
}
