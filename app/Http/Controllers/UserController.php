<?php

namespace App\Http\Controllers;
use Exception;
use App\Mail\OTP;
use App\Models\User;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
  function UserRegistration(Request $request)
  {

                try {

                    $request->validate([
                        'firstName'=>'required|string|max:50',
                        'lastName'=>'required|string|max:50',
                        'email'=>'required|email|unique:users',
                        'mobile'=>'required|string|max:50',
                        'password'=>'required|string|min:4'
                    ]);
                        User::create([
                            'firstName'=>$request->input('firstName'),
                            'lastName'=>$request->input('lastName'),
                            'email'=>$request->input('email'),
                            'mobile'=>$request->input('mobile'),
                            'password'=>Hash::make($request->input('password')),
                        ]);
                
                        return response()->json([
                        'status'=>'success',
                        'message'=>'User created successfully'
                        ],200);
                    


                }catch(Exception $e){
                    return response()->json([
                        'status'=>'Failded',
                        'message'=>"Unable to Register User",
                        'error'=>$e->getMessage()
                    ],200);
                
                }

  }
  
  function UserLogin(Request $request)
  {
    try{

        $request->validate([
            'email'=>'required|string|email|max:50',
            'password'=>'required|string|min:4'
        ]);

        $user = User::where('email',$request->input('email'))->first();
                    
        
        if(!$user || !Hash::check($request->input('password'),$user->password)){
            return response()->json([
                'status'=>'fail',
                'message'=>'Invalid Credentials',
                

            ],200);
        };

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'status'=>'success',
            'message'=>'User Logged In Successfully',
            'token'=>$token
        ]);

        
    

    }catch(Exception $e){
        return response()->json([
            'status'=>'fail',
            'message'=>'Unable to Login User',
            'error'=>$e->getMessage()
        ],200);
    
    
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
    
            Mail::to($email)->send(new OTP($otp));
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
    $request->validate([
        'email'=>'required|string|email|max:50',
        'otp'=>'required|string|min:4'
    ]);
       
    $email = $request->input('email');
    $otp = $request->input('otp');

    $count = User::where('email','=',$email)
                    ->where('otp','=',$otp)
                    ->count();

    try{

    if($count==1)
    {
        //$token = user()->createToken('authToken')->plainTextToken;
        //JWTToken::CreateTokenForSetPassword($request->input('email'));
       
         User::where('email','=',$email)->update(['otp'=>0]);
        return response()->json([
            'status'=>'success',
            'message'=>'OTP Verified Successfully',
            
        ],200);
    
    }

    }catch(Exception $e){

        return response()->json([
            'status'=>'fail',
            'message'=>'Invalid OTP',
            'error'=>$e->getMessage()
        ],200);

    }                             
  }


  function ResetPassword(Request $request)
  {
    try{
    
    $request->validate([
        'password'=>'required|string|min:4'
    ]);

    $id = Auth::user()->id;
    $password = $request->input('password');
    $hashedPassword = Hash::make($password);
    User::where('id','=',$id)->update(['password'=>$hashedPassword]);

    return response()->json([
        'status'=>'success',
        'message'=>'Password Updated Successfully',
        

    ]);

    }catch(Exception $e){
        return response()->json([
            'status'=>'fail',
            'message'=>'Unable to update password',
            'error'=>$e->getMessage()
        ],500);
    
    }
  }

  function GetUserDetails()
  {
    try{
        return response()->json([
            'status' =>'success',
            'message' => 'User Found Successfully',
            'user' => Auth::user()
            

        ],200);
    }catch(Exception $e){
        return response()->json([
            'status' =>'fail',
            'message' => 'Unable to find user',
            'error' => $e->getMessage()
        ],200);
    } 
  }




  //<--Controller for view--------------------------------------------------->


  // Registration View Page
  function RegistrationPage()
  {
      
      return view('pages.auth.registration-page');
  
  }



  function LoginPage()
  {
    return view('pages.auth.login-page');
  }




    function SendOTPPage()
    {
        return view('pages.auth.send-otp-page');
    }

    function VerifyOTPPage()
    {
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage()
    {
        return view('pages.auth.reset-pass-page');
    }

    function DashboardPage()
    {
        return view('pages.dashboard.dashboard-page');
    }

    function UserProfilePage()
    {
           
        return view('pages.dashboard.profile-page');
    }

    

    function UserLogout()
    {

         Auth::user()->tokens()->delete();
        // Auth::logout();
        // redirect user to login page
        return redirect('/userLogin');
    }

    function UpdateUserDetails(Request $request)
    {
        try{
            $request->validate([
                'firstName'=>'required|string|max:50',
                'lastName'=>'required|string|max:50',
                'mobile'=>'required|string|max:50',
                'password'=>'required|string|min:4'
            ]);
            User::where('id','=',Auth::id())->update([
                'firstName'=>$request->input('firstName'),
                'lastName'=>$request->input('lastName'),
                'mobile'=>$request->input('mobile'),
                'password'=>Hash::make($request->input('password')),
                
            ]);
            return response()->json([
                'status'=>'success',
                'message'=>'User updated successfully',
                
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'message'=>'Unable to update user',
                'error'=>$e->getMessage()
            ],500);
        
        }
    
        
    }




}//class end
