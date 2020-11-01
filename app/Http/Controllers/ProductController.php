<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{

    public function getData(){

        return Product::all();
    }

    public function delete_data(Request $request){

        if($request->ajax())
        {
            $obj = Product::find($request->id);
            $obj->delete();
        }

    }

    public function edit_data(Request $request){

        if($request->ajax())
        {
            return Product::find($request->id);
        }

    }

    public function save_data(Request $request){

        $attr['name'] = $request->name;
        $attr['type'] = $request->type;
        $attr['price'] = $request->price;
        $attr['quant'] = $request->quant;
        
        if($request->ajax())
        {
            Product::create($attr);
        }
    }
    
    public function update_data(Request $request){
     
        $attr['name'] = $request->name;
        $attr['type'] = $request->type;
        $attr['price'] = $request->price;
        $attr['quant'] = $request->quant;
        
        if($request->ajax())
        {
            $prod = Product::find($request->id_prod);
            $prod->fill($attr);
            $prod->save();
        }
    }
}
