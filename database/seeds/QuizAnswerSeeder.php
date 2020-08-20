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
<<<<<<< HEAD
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
=======
          ['first_name'=>'Adriano','sex'=>'M'],
          ['first_name'=>'Sandra','sex'=>'F'],
          ['first_name'=>'Mateus','sex'=>'Não Respondeu'],
          ['first_name'=>'Carla','sex'=>'F'],
          ['first_name'=>'Manoel','sex'=>'M'],
          ['first_name'=>'Andressa','sex'=>'Não Respondeu'],
          ['first_name'=>'Lucas','sex'=>'M'],
          ['first_name'=>'Marilene','sex'=>'F'],
          ['first_name'=>'Benicio','sex'=>'M'],
          ['first_name'=>'Rute','sex'=>'Não Respondeu'],
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
        ];
        $middle_names =[
          'Souza','Alencar','Rosa','Oliveira','Pereira','Magalhães'
        ];
        $last_names =[
          'Santana','Dias','Rodrigues','Ferreira','Bretas','Reis'
<<<<<<< HEAD
        ];                           

        $districts =  @json_decode(json_encode(District::whereCityId(2342)->orWhere('city_id',null)->get()), true);
=======
        ];
                
        $sexs = ['F','M','Não Respondeu'];
        $sexs =  @json_decode(json_encode($sexs), true);        
              
        $years_olds = [
          '16-24 Anos',
          '25-34 Anos',
          '35-44 Anos',
          '45-59 Anos',
          'Acima de 60 Anos',
          'Não Respondeu'
        ];
        $years_olds =  @json_decode(json_encode($years_olds), true);        
        
        $salaries = [
          'Até 1 Salário Minimo',
          'Entre 1 e 2 Salários Minimos',
          'Entre 2 e 5 Salários Minimos',
          'Entre 5 e 10 Salários Minimos',
          'Mais de 10 Salários Minimos',
          'Não Respondeu'
        ];
        $salaries =  @json_decode(json_encode($salaries), true);        
        
        $education_levels = [
          'Ensino Fundamental / Incompleto',
          'Ensino Fundamental / Completo',
          'Ensino Médio / Incompleto',
          'Ensino Médio / Completo',
          'Nunca Estudou',
          'Superior / Incompleto',
          'Superior / Completo',
          'Não Respondeu'
        ];
        $education_levels =  @json_decode(json_encode($education_levels), true);        

        $districts =  @json_decode(json_encode(District::whereCityId(2342)->orWhere('city_id',null)->get()), true);

>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                                                    
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
<<<<<<< HEAD
                                                          
                $option_id = $option->id;
                                
=======
                            
                $sex = $first_name['sex'];
                              
                $option_id = $option->id;
                
                //$sex = Arr::random($sexs);
                $years_old = Arr::random($years_olds);
                $salary = Arr::random($salaries);
                $education_level = Arr::random($education_levels);
                
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                $district = Arr::random($districts);
                $district_id = $district['id'];

                DB::table('quiz_answers')->insert([
                    'quiz_campaign_id' => 1,
                    'quiz_question_id' => $question->id,
                    'description' => '',
                    'quiz_option_id' => $option_id,
<<<<<<< HEAD
                    'name' => $name,          
=======
                    'name' => $name,
                    'sex' => $sex,
                    'years_old' => $years_old,
                    'salary' => $salary,
                    'education_level' => $education_level,
                    'state_id' => $campaign->state_id,
                    'city_id' => $campaign->city_id,
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
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
