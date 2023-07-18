<?php

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
        $data = [
            ["name" => "NaoyaHanai", "is_active" => 1, "email" => "naoyahanai@techasia.biz", "password" => Hash::make('hanai333'),'email_verified_at'=> \Carbon\Carbon::now()],
            ["name" => "Dev 1", "is_active" => 1, "email" => "dev1@techasia.biz", "password" => Hash::make('12345678'),'email_verified_at'=> \Carbon\Carbon::now()],
            ["name" => "Dev 2", "is_active" => 1, "email" => "dev2@techasia.biz", "password" => Hash::make('12345678'),'email_verified_at'=> \Carbon\Carbon::now()],
            ["name" => "Mạnh Hiệp", "is_active" => 1, "email" => "manhhiep91@gmail.com", "password" => Hash::make('12345678'),'email_verified_at'=> \Carbon\Carbon::now()],
            ["name" => "Duy Cường", "is_active" => 1, "email" => "nguyenduycuong@techasia.biz", "password" => Hash::make('12345678'),'email_verified_at'=> \Carbon\Carbon::now()],
        ];
        DB::table("users")->insert($data);
    }
}
