<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\Customers;

class LoginController extends Controller
{

    public function login(Request $request){

        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validator->fails()){
            $data=[
                'status'=>422,
                'message'=>$validator->messages()
            ];
        }else{
            $email=$request->email;
            $password=$request->password;

            $customer=Customers::where('email',$email)->first();

            if($customer){
                if(Hash::check($password,$customer->password))
                {
                    $data=[
                        'status'=>200,
                        'customer'=>$customer
                    ];
                }else{
                    $data=[
                        'status'=>404,
                        'message'=>"Incorrect email or password"
                    ];
                }
                
            }else{
                $data=[
                    'status'=>404,
                    'message'=>"Incorrect email or password"
                ];
            }
        }
        return response()->json($data);
    }
}
