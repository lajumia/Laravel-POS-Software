<?php

namespace App\Http\Controllers;
use App\Helper\JWTToken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

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








}//class end
