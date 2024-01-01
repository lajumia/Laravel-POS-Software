<?php

namespace App\Http\Controllers;
use Exception;
use App\Mail\OTP;
use App\Models\User;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function UserRegistration(Request $request){

                try {
                        User::create([
                            'firstName'=>$request->input('firstName'),
                            'lastName'=>$request->input('lastName'),
                            'email'=>$request->input('email'),
                            'mobile'=>$request->input('mobile'),
                            'password'=>$request->input('password'),
                        ]);
                
                        return response()->json([
                        'status'=>'success',
                        'message'=>'User created successfully'
                        ],200);
                    


                }catch(Exception $e){
                    return response()->json([
                        'status'=>'Failded',
                        'message'=>"Unable to Register User"
                    ],500);
                
                }

  }
  
  function UserLogin(Request $request)
  {
    $user = User::where('email','=',$request->input('email'))
                ->where('password','=',$request->input('password'))
                ->count();
    
    if($user==1){
        $token = JWTToken::CreateToken($request->input('email'));
        return response()->json([
            'status'=>'success',
            'message'=>'Login Successful',
            'token'=>$token,
        ]);

    }else{
        return response()->json([
            'status'=>'fail',
            'message'=>'User not found'
        ],404);
        
    }
  
  }


  function SendOTPCode(Request $request)
  {
    try{
        $email = $request->input('email');

        $user = User::where('email','=',$request->input('email'))
                    ->count();
        
        if($user==1){
            $otp = rand(1000,9999);
    
            //Mail::to($email)->send(new OTP($otp));
            User::where('email','=',$email)->update(['otp'=>$otp]);
            return response()->json([
                'status'=>'success',
                'message'=>'OTP Updated Successfully',
                'otp'=>$otp
            ],200);
    
    
        }
    }catch(Exception $e){
        return response()->json([
            'status'=>'fail',
            'message'=>'Unable to send OTP'
        ],500);
    
    }
  
  }

  function VerifyOTP(Request $request)
  {
    $email = $request->input('email');
    $otp = $request->input('otp');

    $count = User::where('email','=',$email)
                    ->where('otp','=',$otp)
                    ->count();

    try{

    if($count==1)
    {
        $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
         User::where('email','=',$email)->update(['otp'=>0]);
        return response()->json([
            'status'=>'success',
            'message'=>'OTP Verified Successfully',
            'token'=>$token
        ],200);
    
    }

    }catch(Exception $e){

        return response()->json([
            'status'=>'fail',
            'message'=>'Invalid OTP',
            'error'=>$e->getMessage()
        ],404);

    }                             
  }










}//class end
