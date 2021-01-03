<?php

use Illuminate\Database\Seeder;
use App\ProductAttr;
class AttrProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productAttrRecords = [
            ['id' => 1, 'product_id'=>1, 'size'=>'S', 'price'=>500000, 'stock'=>100, 'product_attr_code' => '12312312321'],
            ['id' => 2, 'product_id'=>1, 'size'=>'M', 'price'=>520000, 'stock'=>100, 'product_attr_code' => '12424312321'],
            ['id' => 3, 'product_id'=>1, 'size'=>'L', 'price'=>550000, 'stock'=>100, 'product_attr_code' => '11265312321'],
        ];
        ProductAttr::insert($productAttrRecords);
    }
}
