<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Muharrem Özdemir',
                'email' => 'iletisim@muharremozdemir.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$18gVp4z8uHSL5i7QrPgvP.QZCbGvY.A9f7VAOiG9n84yNQNUsA.oi',
                'remember_token' => NULL,
                'created_at' => '2024-03-10 12:18:26',
                'updated_at' => '2024-03-10 12:18:26',
            ),
        ));
        
        
    }
}