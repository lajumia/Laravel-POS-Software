<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    //
    public function CustomerPage(){
        return view('pages.dashboard.customer-page');
    }


    public function CustomerList(Request $request)
    {
        try{
            $customers = Customer::where('user_id',Auth::user()->id)->get();

            return response()->json([
            'status'=>'success',
            'customers'=>$customers],200);

        }catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'message'=>$e->getMessage()],200); 
        
        }

    


     }
    public function CreateCustomer(Request $request)
    {
        try{
            $request->validate([
                'name'=>'required|string|max:50',
                'email'=>'required|email|unique:customers',
                'mobile'=>'required|string|max:50'
                
            ]);
    
            $customer = Customer::create([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
                'user_id' => Auth::user()->id]);

            return response()->json([
                'status'=>'success',
                'message'=>'Customer created successfully'],200);
    


        }catch(Exception $e){
            return response()->json([
                'error'=>'error',
                'message'=>$e->getMessage()],200); 

        }
        
            
    }


    public function UpdateCustomer(Request $request)
    {
        try{
            $request->validate([
                'name'=>'required|string|max:50',
                'email'=>'required|email',
                'mobile'=>'required|string|max:50'
                
            ]);
    
            $customer = Customer::where('id',$request->input('id'))->update([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile')]);

            return response()->json([
                'status'=>'success',
                'message'=>'Customer updated successfully'],200);
    


        }catch(Exception $e){
            return response()->json([
                'error'=>'error',
                'message'=>$e->getMessage()],200); 

        }
        
            
    
    }


    public function DeleteCustomer(Request $request)
    {
        try{
            $customer = Customer::where('id',$request->input('id'))->delete();

            return response()->json([
                'status'=>'success',
                'message'=>'Customer deleted successfully'],200);
    


        }catch(Exception $e){
            return response()->json([
                'error'=>'error',
                'message'=>$e->getMessage()],200); 

        }
        
            
    
    }

    public function CustomerByID(Request $request)
    {
        try{
            $customer = Customer::where('id',$request->input('id'))->first();
            $details = [
                'name'=>$customer->name,
                'email'=>$customer->email,
                'mobile'=>$customer->mobile
            ];

            return response()->json([
                'status'=>'success',
                'customer'=>$details],200);
    


        }catch(Exception $e){
            return response()->json([
                'error'=>'error',
                'message'=>$e->getMessage()],200); 

        }
        
            
    
    
    }
    
}//class end
