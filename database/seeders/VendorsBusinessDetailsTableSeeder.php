<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail; 

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1,'vendor_id'=>1,'shop_name'=> 'MarkShop','shop_address'=> '920','shop_city'=>'Binmaley','shop_state'=>'Pangasinan','shop_country'=>'Philippines','shop_zipcode'=>'2443','shop_mobile'=>'2323232323','shop_website'=>'wavepad.book','shop_email'=>'mark@gmail.com','address_proof'=>'Passport','address_proof_image'=>'test.jpg','business_license_number'=>'2323232','gst_number'=>'4542325454','pan_number'=>'656562325'],
        ];
        VendorsBusinessDetail::insert($vendorRecords);
    }
}
