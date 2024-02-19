<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            ['id'=>1,'section_id'=>1 ,'category_id'=>6,'author_id'=> 4,'vendor_id'=>1,'admin_id'=>0,'admin_type'=>'vendor','product_name'=>'Harry Potter',
            'product_code'=>'HP','product_color'=>'','product_price'=>'200','product_discount'=>10, 'product_weight'=>500, 'product_image'=>'',
            'product_video'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1],

            ['id'=>2,'section_id'=>2 ,'category_id'=>15,'author_id'=> 6,'vendor_id'=>0,'admin_id'=>1,'admin_type'=>'superadmin','product_name'=>'The Awaken',
            'product_code'=>'TA','product_color'=>'','product_price'=>'400','product_discount'=>10, 'product_weight'=>600, 'product_image'=>'',
            'product_video'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1],
        ];
        Product::insert($productRecords);
    }
}
