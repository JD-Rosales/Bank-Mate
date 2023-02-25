<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_types = [
            [
                'type_name' => 'Personal Account',
            ],
            [
                'type_name' => 'Savings Account',
            ],
        ];

        UserType::insert($user_types);
    }
}
