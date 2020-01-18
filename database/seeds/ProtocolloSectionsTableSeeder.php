<?php

use Illuminate\Database\Seeder;

class ProtocolloSectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settingprotocol')->insert([
            'company'   => 'Medmar Navi SpA',
            'section'   => 'Segreteria',
            'progress'  => 'year'
            ]);
    
            DB::table('settingprotocol')->insert([
            'company'   => 'Medmar Navi SpA',
            'section'   => 'Sinistri',
            'progress'  => 'year'
            ]);
    
            DB::table('settingprotocol')->insert([
            'company'   => 'Medmar Navi SpA',
            'section'   => 'Legale',
            'progress'  => 'continuous'
            ]);
    }
}
