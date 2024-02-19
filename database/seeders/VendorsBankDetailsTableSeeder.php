<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail; 

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1,'vendor_id'=>1,'account_holder_name'=> 'Mark','bank_name'=> 'BBDDE','account_number'=>'00992949222','bank_ifsc_code'=>'242424'],
        ];
        VendorsBankDetail::insert($vendorRecords);
    }
}
