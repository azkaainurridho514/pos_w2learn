<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'setting_id' => 1,
            'company_name' => 'Syntax Corporation Indonesia',
            'address' => 'Jl. Pahlawan no.05 Sendang, Sumber, Cirebon',
            'phone' => '0829933',
            'note_type' => 1,
            'discount' => 5,
            'logo_path' => 'adminlte/dist/img/avatar.png',
            'member_card_path' => 'adminlte/dist/img/photo1.png',
        ]);
    }
}
