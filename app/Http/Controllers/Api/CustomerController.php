<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\Customers;


class CustomerController extends Controller
{
    public function index(){

        $customers=Customers::all();
        if($customers->count()>0){
            $data=[
                'status'=>200,
                'customers'=>$customers
            ];
        }else{
            $data=[
                'status'=>200,
                'message'=>"No data Found"
            ];
        }
        return response()->json($data);
    }

    public function register(Request $request){

        $validator=Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email|unique:customers,email',
            'phone'=>'required|digits:10', //integer|size:10
            'age'=>'required|integer|min:1|between:1,150',
            'gender'=>'required|in:"M","F","O"',
            'password'=>'required',
            'address'=>'string',
            'state'=>'string|max:50',
            'country'=>'string|max:50',
            'dob'=>'date_format:Y-m-d',
            'confirm_password'=>'required|same:password',
        ]);

        if($validator->fails()){
            $data=[
                'status'=>422,
                'errors'=>$validator->messages()
            ];
        }else{
            
            $customer = Customers::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'age'=>$request->age,
                'gender'=>$request->gender,
                'password'=>Hash::make($request->password),
                'address'=>$request->address,
                'country'=>$request->country,
                'state'=>$request->state,
                'dob'=>$request->dob
            ]);

            if($customer){
                $data=[
                    'status'=>200,
                    'message'=>"Customer created successfully"
                ];
            }else{
                $data=[
                    'status'=>500,
                    'message'=>"Something went wrong"
                ];
            }
           
        }
        return response()->json($data);

    }

    public function customer($id){
        $customer=Customers::find($id);
        if($customer){
            $data=[
                'status'=>200,
                'customer'=>$customer
            ];
        }else{
            $data=[
                'status'=>200,
                'message'=>"Customer not found"
            ];
        }
        return response()->json($data);
    }

    public function edit($id){
        $customer=Customers::find($id);
        if($customer){
            $data=[
                'status'=>200,
                'customer'=>$customer
            ];
        }else{
            $data=[
                'status'=>200,
                'message'=>"Customer not found"
            ];
        }
        return response()->json($data);
    }

    
}
