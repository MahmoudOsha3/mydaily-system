<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'mahmoudabdelrahim189@gmail.com'],
            [
                'name' => 'Mahmoud Abdelrahim',
                'phone' => '01201955377',
                'country' => 'Egypt',
                'password' => Hash::make('Osha.com01640164#'),
            ]
        );
    }
}
