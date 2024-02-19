<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
            ['id'=>2,'name'=>'Mark', 'type'=>'vendor','vendor_id'=>1,'mobile'=>'9998887776',
            'email'=>'mark@gmail.com','password'=>'$2a$12$p2UzjHgenu8x/XBJdu6XYOBhk8i9uhzenDCwBbF..XtxQf2MM2sAe','image'=>'','status'=>1],

    ];
    Admin::insert($adminRecords);
    }
}
