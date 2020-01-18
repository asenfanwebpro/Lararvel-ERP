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
        //disabilita le relazioni foreign key tra le tabelle
        //DB::statement('SET FOREIGN_KEY_CHECKS=0');
        //User::truncate(); 

        #$this->call(UsersTableSeeder::class);
        $this->call(SocietaTableSeeder::class);
        $this->call(ProtocolloSectionsTableSeeder::class);
        $this->call(ProtocolloFormsTableSeeder::class);
    }
}
