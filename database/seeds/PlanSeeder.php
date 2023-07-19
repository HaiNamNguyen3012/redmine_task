<?php

use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (in_array(env('ENVIRONMENT_STRIPE'), ["local", "development"])) {
            $data = [
                [
                    "name" => "Gói miễn phí",
                    "price" => 0,
                    "project_quantity" => "1",
                    "payment_service_product_id" => "",
                    "type" => "free",
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    "name" => "Kế hoạch tiêu chuẩn",
                    "price" => 3000,
                    "project_quantity" => "999999999",
                    "payment_service_product_id" => "price_1McJEYCFue9VH2D91i4FXJ21",
                    "type" => "standard",
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]
            ];
        }

        if (env('ENVIRONMENT_STRIPE') == 'production') {
            $data = [
                [
                    "name" => "Gói miễn phí",
                    "price" => 0,
                    "project_quantity" => "1",
                    "payment_service_product_id" => "",
                    "type" => "free",
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    "name" => "Kế hoạch tiêu chuẩn",
                    "price" => 3000,
                    "project_quantity" => "999999999",
                    "payment_service_product_id" => "price_1McQIwCFue9VH2D9wecw72og",
                    "type" => "standard",
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]
            ];
        }

        DB::table("plans")->truncate();
        DB::table("plans")->insert($data);
    }
}
