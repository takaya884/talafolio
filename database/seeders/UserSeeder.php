<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // その他のシーダー
        ]);
    }
}
