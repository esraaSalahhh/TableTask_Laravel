<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\data;
use Validator;
use DB;
class dataController extends Controller
{

    public function get_data(Request $request){
    	$data=data::get()->toJson(JSON_PRETTY_PRINT);
    	return response($data,200);
    }

    public function add_data(Request $request){
    	$Validator=validator::make($request->all(),[
    		'name'=>'required',
    		'price'=>'required',
    		'quantity'=>'required'
    		]);
    	$new_data= new data;

    	$new_data->name=$request->name;
    	$new_data->price=$request->price;
    	$new_data->quantity=$request->quantity;
    	$new_data->save();
    	return response()->json([
     	'message' => 'add product',
     	'id'=>$new_data->id,
 		'code' => 200,
    	]);
    }

    public function delete_data($id){
    	if(data::where('id',$id)->exists()){
    		$data=data::find($id);
    		$data->delete();
    		return response()->json([
    		'message' => 'delete product',
 			'code' => 200,
    			]);
    	}
    	return response()->json([
    		'message' => 'product not found',
 			'code' => 401,
    			]);
    }

    public function update_data(Request $request ,$id){
    	if(data::where('id',$id)->exists()){
    		$data=data::find($id);
    		$data->name = is_null($request->name) ? $data->name : $request->name;
    		$data->price = is_null($request->price) ? $data->price : $request->price;
    		$data->quantity = is_null($request->quantity) ? $data->quantity : $request->quantity;
    		$data->save();
    		return response()->json([
    		'message' => 'update product',
    		'name'=>$data->name,
    		'price'=>$data->price,
    		'quantity'=>$data->quantity,
    		'rname'=>$request->name,
    		'rprice'=>$request->price,
    		'rquantity'=>$request->quantity,
 			'code' => 200,
    			]);
    	}
    	return response()->json([
    		'message' => 'product not found',
 			'code' => 401,
    			]);

    }
}
