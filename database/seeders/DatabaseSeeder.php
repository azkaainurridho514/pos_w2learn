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
        // User::create([
        //     'name' => 'Azka Ainurridho',
        //     'email' => 'azkaainurridho514@gmail.com',
        //     'password' => bcrypt('password'),
        //     'level' => 1
        // ]);

        // User::create([
        //     'name' => 'user satu',
        //     'email' => 'usersatu@gmail.com',
        //     'password' => bcrypt('password'),
        //     'level' => 0
        // ]);

        $this->call([
            SettingTableSeeder::class
        ]);
    }
}
