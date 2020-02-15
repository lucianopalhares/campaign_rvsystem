<?php

use Illuminate\Database\Seeder;

class QuizCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quiz_campaigns')->insert([
            'id' => 1,
            'active' => 1,
            'description' => 'Descrição da Campanha Teste',
            'slug' => 'campanha-teste'
        ]);
    }
}
