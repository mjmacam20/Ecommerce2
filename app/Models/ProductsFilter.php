<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsFilter extends Model
{
    use HasFactory;
    public static function getFilterName($filter_id){
        $getFilterName = ProductsFilter::select('filter_name')->where('id',$filter_id)->first();
        return $getFilterName->filter_name;
    }

    public function filter_values(){
        return $this->hasMany('App\Models\ProductsFiltersValue','filter_id');
    }

    public static function productFilters(){
        $productFilters = ProductsFilter::with('filter_values')->where('status',1)->get()->toArray();
        //dd($productFilters);
        return $productFilters;
    }

    public static function filterAvailable($filter_id, $category_id){
        $filterAvailable = ProductsFilter::select('cat_ids')->where(['id'=>$filter_id,'status'=>1])->first()->toArray();
        $catIdsArr = explode(",",$filterAvailable['cat_ids']);
        if(in_array($category_id,$catIdsArr)){
            $available = "Yes";
        }else{
            $available = "No";
        }
        return $available;
    }

    //public static function getSizes($url){
    //    $categoryDetails = Category::categoryDetails($url);
    //    echo "<pre>"; print_r($categoryDetails); die;
    //}
}
