<?php

use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('people')->insert([
            'id' => 1,
            'first_name' => 'Admin',
            'last_name' => '(Administrador)',
            'cpf' => '000.000.000-00',
            'sex' => 'M',
            'slug' => 'admin',
            'nickname' => 'Admin',
            'years_old' => '18',
            'birth' => '1999-12-31',
            'salary' => '10452.99',
            'education_level' => 'Superior / Completo',
            'user_id' => 1
        ]);
             
    }
}
