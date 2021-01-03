<?php

use Illuminate\Database\Seeder;
use App\ProductImage;
class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $productImageRecords = [
            ['id' => 1, 'product_id'=>1, 'image' => 'https://dummyimage.com/100X115/f7f7f7/090a1a.png&text=No+Image', 'status' => 1],
            ['id' => 2, 'product_id'=>1, 'image' => 'https://dummyimage.com/100X115/f7f7f7/090a1a.png&text=No+Image', 'status' => 1],
            ['id' => 3, 'product_id'=>1, 'image' => 'https://dummyimage.com/100X115/f7f7f7/090a1a.png&text=No+Image', 'status' => 1]
        ];
        ProductImage::insert($productImageRecords);
    }

}
