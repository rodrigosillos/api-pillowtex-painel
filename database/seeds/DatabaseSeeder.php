<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_profile')->insert([
            [
                'name' => 'Administrador',
                'description' => '',
            ],
            [
                'name' => 'Gerente',
                'description' => '',
            ],
            [
                'name' => 'Representante',
                'description' => '',
            ]
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Rodrigo Sillos',
                'email' => 'rodrigosillos@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$10$6i2mDhx4blyVk7VKpXOSi.JKvUEXQ/7El9jecGEcYXIjOnkQnoKmq',
                'remember_token' => null,
            ]
        ]);
    }
}
