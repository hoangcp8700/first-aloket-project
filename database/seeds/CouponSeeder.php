<?php

use App\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'code' => 'ABC123',
            'quantity' => 100,
            'type' => '%',
            'value' => '30',

        ]);

        Coupon::create([
            'code' => 'DEF234',
            'quantity' => 100,
            'type' => '$',
            'value' => '50000',

        ]);
    }
}
