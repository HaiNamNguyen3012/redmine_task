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
            ["name" => "Hiep", "is_active" => 1, "email" => "manhhiep91@gmail.com", "password" => Hash::make('12345678')],
        ];
        DB::table("admins")->insert($data);
    }
}
