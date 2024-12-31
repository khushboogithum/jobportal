<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiUser;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class ApiController extends Controller
{
    public function index(){
        $array=[
                [
                    "name"=>'khushboo',
                    "email"=>'khushboo@gmail.com'
                ],
                [
                    "name"=>'Sonu',
                    "email"=>'sonu@gmail.com'
                ]

            ];
        return response()->json([
            'message'=>'2 User found',
            'data'=>$array,
            'status'=>true
        ]);    
    }
    public function userList(){
        $users=ApiUser::all();
        $countUser=$users->count();
        return response()->json([
            'message'=>$countUser.' User Added successfully',
            'data'=>$users,
            'status'=>true
        ]);
    }
    public function getOneUser($id){
        //print_r($id);
        $userData=ApiUser::find($id);
      //  print_r($userData->toArray());
        if($userData!=null){
            return response()->json([
                'message'=>'User data listed',
                'data'=>$userData,
                'success'=>true
            ]);
        }else{
            return response()->json([
                'message'=>'No data found',
                'data'=>[],
                'success'=>false
            ]);
        }
    }
    public function store(Request $request){
       $validator= Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'designation'=>'required',
            'mobile'=>'required'
       ]);
       if($validator->fails()){
            return response()->json([
                'message'=>'Please fixed the error',
                'errors'=>$validator->errors(),
                'success'=>false
            ],200);
       }
       if($validator->passes()){
            $user=new ApiUser();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->designation=$request->designation;
            $user->mobile=$request->mobile;
            $user->save();

            return response()->json([
                'message'=>'Data Added successfully',
                'data'=>$user,
                'last_inserted_id'=>$user->id,
                'success'=>true
            ],200);
      
       }
    }
    public function update(Request $request,$id){
       
       $user= ApiUser::find($id);
       if($user==null){
        return response()->json([
            'message'=>'User not found',
            'success'=>false
        ],200);
       }
        $validator= Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'designation'=>'required',
            'mobile'=>'required'
       ]);
       if($validator->fails()){
            return response()->json([
                'message'=>'Please fixed the error',
                'errors'=>$validator->errors(),
                'success'=>false
            ],200);
        }
        $user->name=$request->name;
        $user->email=$request->email;
        $user->designation=$request->designation;
        $user->mobile=$request->mobile;
        $user->save();

        return response()->json([
            'message'=>'Data updated successfully',
            'data'=>$user,
            'last_inserted_id'=>$user->id,
            'success'=>true
        ],200);
  
    }
    public function destroy($id){
        $user=ApiUser::find($id);
        if($user==null){
            return response()->json([
                'message'=>'User not found',
                'success'=>false
            ],200);
        }
        $user->delete();
        return response()->json([
            'message'=>'Data delete successfully',
            'success'=>true
        ],200);
  
    }
    public function uploadimage(Request $request){
        $validator= Validator::make($request->all(),[
            'image'=>'required|mimes:png,jpg,jpeg,gif'
       ]);
       if($validator->fails()){
            return response()->json([
                'message'=>'Please fixed the error',
                'errors'=>$validator->errors(),
                'success'=>false
            ],200);
        }
        $img=$request->image;
        $ext=$img->getClientOriginalExtension();
        $imageName=time().'.'.$ext;
        $img->move(public_path().'/upload/',$imageName);

        $image=new Image();
        $image->image=$imageName;
        $image->save();
        return response()->json([
            'message'=>'Image Uploaded successfully',
            'data'=>$image,
            'path'=>asset('upload/'.$imageName),
            'success'=>true
        ],200);
    }
}
