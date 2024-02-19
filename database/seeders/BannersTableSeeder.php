<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords = [
            ['id'=>1, 'image'=>'banner-1.png','link'=>'books-ads','title'=>'Book Ads','alt'=>'Book Ads','status'=>1],
            ['id'=>2, 'image'=>'banner-2.png','link'=>'books-ads-2','title'=>'Book Ads-2','alt'=>'Book Ads-2','status'=>1],
        ];
        Banner::insert($bannerRecords);
    }
}
