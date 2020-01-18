<?php

use Illuminate\Database\Seeder;
//use App\User;

class SocietaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$faker = Faker\Factory::create('it_IT');
        
        DB::table('societa')->insert([
            'user_id' => '1',
            'ragione_sociale' => strtoupper('Medmar Navi SpA'),
            'citta' => 'Napoli',
            'indirizzo' => 'Via Alcide De Gasperi, 55',
            'cap' => '80133',
            'iva' => '05984260637',
            'cf' => '05984260637',
            'sdi' => Str::random(10),
            'mail' => 'info@medmarnavi.it',
            'pec' => 'info@medmarnavi.it',
            'tel' => '0815801223',
            'fax' => '0815267736',
            'web' => 'www.medmarnavi.it',
            'firma' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Firma_Len%C3%ADn_Moreno_Garc%C3%A9s.png/800px-Firma_Len%C3%ADn_Moreno_Garc%C3%A9s.png',
            'logo' => 'https://biglietteria.medmargroup.it/assets/images/logo.png'
        ]);
    }
}
