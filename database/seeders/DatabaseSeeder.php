<?php

namespace Database\Seeders;

use App\Models\User;
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
        // \App\Models\User::factory(10)->create();

        $user = User::factory()->create([
            "name" => "ayoub",
            'email' => "ayoub@gmail.com",
            "password" => bcrypt("123456"),
        ]);

        \App\Models\Listing::factory(10)->create([
            "user_id" => $user->id
        ]);
    }
}
