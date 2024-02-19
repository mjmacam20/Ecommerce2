<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authorRecords = [
            ['id'=>1,'name'=>'Steve Jobs', 'status'=>1],
            ['id'=>2,'name'=>'J.K. Rowling', 'status'=>1],
            ['id'=>3,'name'=>'Jose Rizal', 'status'=>1],
            ['id'=>4,'name'=>'Albert Tirao', 'status'=>1],
            ['id'=>5,'name'=>'Mark Salas', 'status'=>1],
            ['id'=>6,'name'=>'Lana Sison', 'status'=>1],
            ['id'=>7,'name'=>'Joshua Ferrer', 'status'=>1],
        ];
        Author::insert($authorRecords);
    }
}
