<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1,'name'=> 'Mark','address'=> '244','city'=> 'Binmaley','state'=>'Pangasinan','country'=>'Philippines','zipcode'=>'2443','mobile'=>'2323232323','email'=>'mark@gmail.com','status'=>0],
        ];
        Vendor::insert($vendorRecords);
    }
}
