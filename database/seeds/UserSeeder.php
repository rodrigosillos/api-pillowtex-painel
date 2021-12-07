<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
                'user_profile_id' => 1,
                'address_city' => 'SAO PAULO',
                'address_state' => 'SP',
            ],
            [
                'name' => 'Luiz Galdino',
                'email' => 'luiz.galdino@pillowtex.com.br',
                'email_verified_at' => null,
                'password' => '$2y$10$6i2mDhx4blyVk7VKpXOSi.JKvUEXQ/7El9jecGEcYXIjOnkQnoKmq',
                'remember_token' => null,
                'user_profile_id' => 1,
                'address_city' => 'SAO PAULO',
                'address_state' => 'SP',
            ],
            [
                'name' => 'Melissa Gomes',
                'email' => 'melissa.gomes@zonacriativa.com.br',
                'email_verified_at' => null,
                'password' => '$2y$10$6i2mDhx4blyVk7VKpXOSi.JKvUEXQ/7El9jecGEcYXIjOnkQnoKmq',
                'remember_token' => null,
                'user_profile_id' => 1,
                'address_city' => 'SAO PAULO',
                'address_state' => 'SP',
            ],
            [
                'name' => 'Comercial 05',
                'email' => 'comercial05@zonacriativa.com.br',
                'email_verified_at' => null,
                'password' => '$2y$10$6i2mDhx4blyVk7VKpXOSi.JKvUEXQ/7El9jecGEcYXIjOnkQnoKmq',
                'remember_token' => null,
                'user_profile_id' => 1,
                'address_city' => 'SAO PAULO',
                'address_state' => 'SP',
            ],
        ]);
    }
}
