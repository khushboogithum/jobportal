<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;
use App\Models\SavedJob;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use Carbon\Carbon;

class AccountController extends Controller
{

    //This method is show user registration
    public function registration(){

        return view ('front.account.registration');
    }
    public function processRegistration(Request $request){

      $validator=Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required|email|unique:users,email',
        'password'=>'required|min:5|same:confirm_password',
        'confirm_password'=>'required',

      ]);

      
      if($validator->passes()){
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();

        session()->flash('success','You have registered successfully');
        return response()->json([
          'status' => true,
          'errors' => []
        ]);

      }else{
          return response()->json([
            'status' => false,
            'errors' => $validator->errors()
          ]);
      }

    }
    //This method is show user login
    public function login(){
      return view ('front.account.login');
    }
    public function authenticate(Request $request){
      $validator = Validator::make($request->all(), [
          'email' => 'required|email',
          'password' => 'required'
      ]);

      if($validator->passes()){
        if (Auth::attempt(['email' => $request->email,'password'=>$request->password])){
            return redirect()->route('account.profile');
        }else{
          return redirect()->route('account.login')->with('error','Email or Password are incorrect');
        }
      } else {
          return redirect()->route('account.login')
              ->withErrors($validator)
              ->withInput($request->only('email'));
      }
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }
    public function profile(){

        $id=Auth::user()->id;
        $user=User::where('id',$id)->first();
        //$user=User::find($id);    //second method
        // dd($user);
        return view ('front.account.profile',['user'=>$user]);
    }
    public function updateProfile(Request $request){
        $id=Auth::user()->id;
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:5|max:20',
            'email'=>'required|email|unique:users,email,'.$id.',id'
        ]);
        if($validator->passes()){
            $user=User::find($id);
            $user->name=$request->name;
            $user->email=$request->email;
            $user->designation=$request->designation;
            $user->mobile=$request->mobile;
            $user->save();

            session()->flash('success','Profile updated successfully.');
            return response()->json([
                'status'=>true,
                'errors'=>[]
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }
    }
    public function updatePic(Request $request){
       //dd($request->all());
       $id=Auth::user()->id;
      $validator=Validator::make($request->all(),[
        'image'=>'required|image'
      ]);
      if($validator->passes()){
        $image=$request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName=$id.'-'.time().'.'.$ext;
        $image->move(public_path('/profile_pic/'), $imageName);
        User::where('id',$id)->update(['image'=>$imageName]);

        session()->flash('success','Profile picture updated successfully.');
        return response()->json([
            'status'=>true,
            'errors'=>[]
          ]);
      }else{
        return response()->json([
          'status'=>false,
          'errors'=>$validator->errors()
        ]);
      }
    }
    public function createJob(){

        $categories=Category::orderBy('name','ASC')->where('status',1)->get();
        $jobType=JobType::orderBy('name','ASC')->where('status',1)->get();
        return view('front.account.job.create',[
            'categories'=>$categories,
            'jobtype'=>$jobType,
        ]);
    }
    public function saveJob(Request $request){

        $rules=[
            'title'=>'required|min:5|max:200',
            'category'=>'required',
            'jobType'=>'required',
            'vacancy'=>'required|integer',
            'location'=>'required|max:50',
            'description'=>'required',
            'company_name'=>'required|min:3|max:75',

        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->passes()){
            $Job=new Job();
            $Job->title=$request->title;
            $Job->category_id =$request->category;
            $Job->job_type_id =$request->jobType;
            $Job->user_id =Auth::user()->id;
            $Job->vacancy=$request->vacancy;
            $Job->salary=$request->salary;
            $Job->location=$request->location;
            $Job->description=$request->description;
            $Job->benefits=$request->benefits;
            $Job->responsibility=$request->responsibility;
            $Job->qualifications=$request->qualifications;
            $Job->keywords=$request->keywords;
            $Job->experience=$request->experience;
            $Job->company_name=$request->company_name;
            $Job->company_location=$request->location;
            $Job->company_website=$request->website;
            $Job->save();

            session()->flash('success','Job Added Successfully');
            return response()->json([
                'status'=>true,
                'errors'=>[]
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }
    }
    public function myJobs(){
        $jobs=Job::where('user_id',Auth::user()->id)->with(['jobType','applications'])->orderBy('created_at','DESC')->paginate(5);
        // echo $currect=Carbon::now();
        // die();
       // dd($jobs);
        return view('front.account.job.my-jobs',compact('jobs'));
    }
    public function editjob(Request $request,$id){
        $categories=Category::orderBy('name','ASC')->where('status',1)->get();
        $jobtype=JobType::orderBy('name','ASC')->where('status',1)->get();

        $job=job::where([
            'user_id'=>Auth::user()->id,
            'id'=>$id
        ])->first();
        if($job==NULL){
            abort(404);

        }
        return view('front.account.job.edit',compact('categories','jobtype','job'));
    }
    public function updateJob(Request $request,$id){

        $rules=[
            'title'=>'required|min:5|max:200',
            'category'=>'required',
            'jobType'=>'required',
            'vacancy'=>'required|integer',
            'location'=>'required|max:50',
            'description'=>'required',
            'company_name'=>'required|min:3|max:75',

        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->passes()){
            $Job=Job::find($id);
            $Job->title=$request->title;
            $Job->category_id =$request->category;
            $Job->job_type_id =$request->jobType;
            $Job->user_id =Auth::user()->id;
            $Job->vacancy=$request->vacancy;
            $Job->salary=$request->salary;
            $Job->location=$request->location;
            $Job->description=$request->description;
            $Job->benefits=$request->benefits;
            $Job->responsibility=$request->responsibility;
            $Job->qualifications=$request->qualifications;
            $Job->keywords=$request->keywords;
            $Job->experience=$request->experience;
            $Job->company_name=$request->company_name;
            $Job->company_location=$request->location;
            $Job->company_website=$request->website;
            $Job->save();

            session()->flash('success','Job Updated Successfully');
            return response()->json([
                'status'=>true,
                'errors'=>[]
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }
    }
    public function deletejob(Request $request){

        $job=job::where([
            'user_id'=>Auth::user()->id,
            'id'=>$request->jobId
        ])->first();

        if($job==NULL){
            session()->flash('error','Either Job deleted or not found.');
            return response()->json([
                'status'=>false
            ]);
        }
       // dd($request->all());
        $deleteJob = job::where('id', $request->jobId)->delete();
        if ($deleteJob) {
            session()->flash('success', 'Job Deleted Successfully');
            return response()->json([
                'status' => true
            ]);
        }else{
            session()->flash('error', 'Job not Deleted Successfully');
            return response()->json([
                'status' => false
            ]);
        }
    }
    public function myJobApplications(){
       $jobApplications=JobApplication::where('user_id',Auth::user()->id)
       ->with(['job','job.jobType','job.applications'])
       ->paginate(10);
       //dd($jobs);
        return view('front.account.job.my-job-application',compact('jobApplications'));
    }

    public function removeJobs(Request $request){
       // echo $request->id;
        $jobApplication=JobApplication::where([
                'id'=>$request->id,
                'user_id'=>Auth::user()->id
            ])->first();
      // dd($jobApplication);
        if($jobApplication==null){
            session()->flash('error','Job application not found');
            return response()->json([
                'status'=>false
            ]);
        }
            JobApplication::find($request->id)->delete();
            session()->flash('success','Job application removed successfully');
            return response()->json([
                'status'=>true
            ]);
    }
    public function saveJobList(){
        $savejobs=SavedJob::where('user_id',Auth::user()->id)
        ->with(['job','job.jobType','job.applications'])
        ->orderBy('created_at','DESC')->paginate(5);
        // echo $currect=Carbon::now();
        // die();
       // dd($savejobs);
        return view('front.account.job.save-job-list',compact('savejobs'));
    }
    public function savedeletejob(Request $request){
        $deleteSaveJob=SavedJob::where([
            'id'=>$request->savejobId,
            'user_id'=>Auth::user()->id
        ])->first();
    // dd($deleteSaveJob);
        if($deleteSaveJob==null){
            session()->flash('error','Job save not found');
            return response()->json([
                'status'=>false
            ]);
        }
            SavedJob::find($request->savejobId)->delete();
            session()->flash('success','Save Job removed successfully');
            return response()->json([
                'status'=>true
            ]);
    }

}
