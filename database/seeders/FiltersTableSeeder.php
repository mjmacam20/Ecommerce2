<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\ProductsFilter;
class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filterRecords = [
            ['id'=>'1','cat_ids'=>'1,14,11,12,7,10','filter_name'=>'Romance','filter_column'=>'romance','status'=>1],
            ['id'=>'2','cat_ids'=>'16,17','filter_name'=>'History','filter_column'=>'history','status'=>1]
        ];  
        ProductsFilter::insert($filterRecords);
    }
}
