<?php

namespace Database\Seeders;

use App\Models\Panel\Navigation\Profile;
use App\Models\Panel\Navigation\UserProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'E-code',
                'cpf' => '00000000000',
                'email' => 'admin@agenciaecode.com.br',
                'password' => Hash::make('123'),
                'status' => true
            ]
        ]);

        Profile::insert([
            [
                'name' => 'Admin',
                'status' => true
            ]
        ]);

        UserProfile::insert(
            [
                'profile_id' => 1,
                'user_id' => 1
            ]
        );
    }
}
