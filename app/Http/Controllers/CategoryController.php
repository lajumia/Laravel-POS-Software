<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //
    public function CreateCategory(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
            
            $category = Category::where('name', $request->input('name'))->first();
            if($category){
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Category already exists'
                ],200);
            }
            
            $category = Category::create([
                'name' => $request->input('name'),
                'user_id' => Auth::user()->id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Category Created',
                'category' => $category
            ],201);
        




        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
               'message' => $e->getMessage()
            ],200);
        

        }

    }


    public function UpdateCategory(Request $request)
    {
        try{
            $request->validate([
                'id' => 'required|integer',
                'name' => 'required|string|max:255',
            ]);
            
            Category::where('id', $request->input('id'))->update([
                'name' => $request->input('name')
                
            ]);

            $category = Category::where('id', $request->input('id'))->first();

            return response()->json([
                'status' => 'success',
                'message' => 'Category Updated',
                'category' => $category
            ],200);


        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
               'message' => $e->getMessage()
            ],200);
        

        }
    }


    public function DeleteCategory(Request $request)
    {
        try{
            $request->validate([
                'id'=>'required|integer',
            ]);

            Category::where('id',$request->input('id'))->delete();
            return response()->json([
                'status'=>'success',
                'message'=>'Category Deleted'

            ]);
        }catch(Exception $e){
            return response().json([
                'status'=>'failed',
                'message'=>$e->getMessage()
            ]);

        }
    }

    public function ListCategory()
    {
        try{
            $category = Category::all();
            return response()->json([
                'status'=>'success',
                'category'=>$category
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status'=>'failed',
                'message'=>$e->getMessage()
            ],200);
        }
    
    }

    public function CategoryByID(Request $request){
        $category = Category::where('id',$request->input('id'))->first();
        return response()->json([
            'status'=>'success',
            'categoryName'=>$category['name']
        ],200);
    
    }

    public function CategoryPage(){
              return view('pages.dashboard.category-page');
    
    }



        
    
}// end class
