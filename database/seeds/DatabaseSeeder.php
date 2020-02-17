<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**$this->call(UserSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(PoliticalOfficeSeeder::class);
        $this->call(PersonSeeder::class);   
        $this->call(QuizCampaignSeeder::class);   */
        $this->call(QuizAnswerSeeder::class);
                           
    }
}
