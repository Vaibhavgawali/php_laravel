<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;

class ProductController extends Controller
{
   public  function index() {
        return view('home');
    }
    public function products(Request $request){
        $search=$request['search']??'';

        if($search != null){
            $products = ProductModel::where('product_name','LIKE',"%$search%")->orwhere('product_price','LIKE',"%$search%");
            $products = $products->paginate(10);

            $products->appends('search',$search);
        }else{
            $products = ProductModel::paginate(10);
        }
        $data=compact('products','search');
        return view('products')->with($data);
    }
    public function contact(){
        return view('contact');
    }
    public function login(){
        return view('login');
    }
}
