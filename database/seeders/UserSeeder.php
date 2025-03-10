<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // すでに存在するかを確認してから作成
        if (!User::where('email', 'sutaron582@gmail.com')->exists()) {
            User::factory()->create();
        }
    }
}
