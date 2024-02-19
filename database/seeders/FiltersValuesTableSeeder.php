<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsFiltersValue;
class FiltersValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filterValueRecords = [
            ['id'=>1,'filter_id'=>1,'filter_value'=>'Romantic Suspense','status'=>1],
            ['id'=>2,'filter_id'=>1,'filter_value'=>'Adult Romance','status'=>1],
            ['id'=>3,'filter_id'=>2,'filter_value'=>'Psychological Horror','status'=>1],
            ['id'=>4,'filter_id'=>2,'filter_value'=>'Demons','status'=>1],
        ];
        ProductsFiltersValue::insert($filterValueRecords);
    }
}
