<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsAttribute;

class ProductAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productAttributesRecords = [
            ['id'=>1,'product_id'=>2,'size'=>'Set A','price'=>405,'stock'=>'10','sku'=>'TA-A','status'=>1],
            ['id'=>2,'product_id'=>2,'size'=>'Set B','price'=>410,'stock'=>'15','sku'=>'TA-B','status'=>1],
            ['id'=>3,'product_id'=>2,'size'=>'Set C','price'=>800,'stock'=>'25','sku'=>'TA-C','status'=>1],
        ];
        ProductsAttribute::insert($productAttributesRecords);
    }
}