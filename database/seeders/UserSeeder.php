<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\GenderEnum;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'user',
            'email' => 'user@user.com',
            'phone' => '0993571188',
            'password' => 'p@$$word',
            'birthday' => '1990-01-01',
            'gender' =>  GenderEnum::Male->value,
        ]);

        User::factory()->count(3)->create();
    }
}
