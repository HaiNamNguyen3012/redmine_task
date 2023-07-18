<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["name" => "NaoyaHanai", "is_active" => 1, "email" => "naoyahanai@techasia.biz", "password" => Hash::make('hanai555')],
        ];
        DB::table("admins")->insert($data);
    }
}
