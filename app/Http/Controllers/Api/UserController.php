<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Validator;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\EmailVerified;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
    * Crete new user and send email 
    */
    public function registerUser(Request $request): Response
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>[
                        'required',
                        Password::min(8)
                                ->mixedCase()
                                ->numbers()
                                ->symbols()
                                ->uncompromised()
                    ]
        ]);

        if($validator->fails()){
            return Response(['message' => $validator->errors()],401);
        }   

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password  //Hash::make($request->password),
        ]);

        if($user){
            event(new Registered($user));
            // if($user->sendEmailVerificationNotification()){
            //     return Response(['message' => "Email is sent to email"],200);
            // }
            return Response(['message' => "User created successfully"],200);
        }

        return Response(['message' => "Something went wrong"],500);

    }

    /**
     * Login user.
     */
    public function loginUser(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if($validator->fails()){

            return Response(['message' => $validator->errors()],401);
        }
   
        if(Auth::attempt($request->all())){

            $user = Auth::user(); 
    
            $success =  $user->createToken('MyApp')->plainTextToken; 
        
            return Response(['token' => $success],200);
        }

        return Response(['message' => 'email or password wrong'],401);
    }

     /**
     * Display logged user details.
     */
    public function userDetails(): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            return Response(['data' => $user],200);
        }

        return Response(['data' => 'Unauthorized'],401);
    }

    /**
     * Display all the users.
     */
    public function allUsers(): Response
    {
        if (Auth::check()) {

            $users=User::all();

            return Response(['data' => $users],200);
        }

        return Response(['data' => 'Unauthorized'],401);
    }

    /**
    * Display specified user.
    */
    public function user($id) : Response
    {
        if(Auth::check()){
            $user=User::find($id);

            if($user){
                return Response(['user'=>$user],200);
            }
            else{
                return Response(['message'=>"User not found"],404);
            }
        }

        return Response(['message'=>'Unauthorized'],401);
    }

    /**
     * Upload image image of logged user
     */
    public function imageUpload(Request $request):Response
    {
        if(Auth::check()){

            $validator=Validator::make($request->all(),[
                'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if($validator->fails()){
                return Response(['message' => $validator->errors()],401);
            } 

            // Save the image to the storage
            $image=$request->file("image");
            $imageName=$image->hashName();

            $imagepath= Storage::disk('local')->put('public/images', $image);
            // $imagepath = $image->storeAs('public/images', $imageName);

            if ($imagepath) {

                // Image is stored
                $user = Auth::user();

                // Delete the old image
                if($user->image){
                    $oldimage=$user->image;
                    Storage::delete($oldimage);
                }

                $user->image = $imagepath;
                $user->save();
                return Response(['message' => 'Image stored successfully', 'path' => $imagepath]);
            } else {
                // Image storage failed
                return Response(['message' => 'Failed to store image'], 500);
            }            
        }
        return Response(['message'=>'Unauthorized'],401);
    }

    /**
     * Delete user
     */
    public function deleteUser($id) : Response
    {
        if(Auth::check()){
            $user=User::find($id);
            
            if($user){
                if($user->delete()){
                    return Response(['message'=>"User deleted successfully"],200);
                }
                return Response(['message'=>"Something went wrong !"],500);
            }
            return Response(['message'=>"User not found"],404);
        }
        return Response(['message'=>'Unauthorized'],401);
    }

    /**
    * Logout user.
    */
    public function logout(): Response
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();
        
        return Response(['data' => 'User Logout successfully.'],200);
    }



    /**
    * Refresh Token
    */
    public function refreshAuthToken()
    {
        $user = Auth::user();

        // Revoke the current token
        $user->currentAccessToken()->delete();

        // Issue a new token
        $newToken = $user->createToken('new-token-name')->plainTextToken;

        return Response(['access_token' => $newToken],200);
    }

    /**
    * Send email verification notification.
    */
    public function sendVerificationEmail(Request $request)
    {
        $email=$request->email;

        $user=User::where('email', $email)->first();

        // print_r(date($user->email_verified_at));
        // die;

        if (!date($user->email_verified_at)) {

            $user->sendEmailVerificationNotification();
            return Response(['message' => 'Verification link sent!']);

        }   
        return Response(['message' => 'User already verified!']);
    }

    /**
    * Mark the authenticated user's email address as verified.
    */
    public function verifyEmail(EmailVerificationRequest $request)
    {
        print_r($request->all());die;
        $request->fulfill();

        // event(new Verified($request->user()));

        return Response(['status' => 'ok']);
    }

    public function emailVerified() {
        return Response(["status" => "verified"]);
    }

}
