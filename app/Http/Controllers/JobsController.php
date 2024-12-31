<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\User;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{
    //This method show job page
    public function index(Request $request){

        $categories=Category::where('status',1)->get();
        $jobTypes=jobType::where('status',1)->get();

        $jobs=Job::where('status',1);

        //search using keywords
        if(!empty($request->keyword)){
            $jobs=$jobs->where(function($query) use($request){
                $query->orWhere('title','like','%'.$request->keyword.'%');
                $query->orWhere('keywords','like','%'.$request->keyword.'%');
            });
        }
        //search using location
        if(!empty($request->location)){
            $jobs=$jobs->where('location','like','%'.$request->location.'%');
        }
        //search using category
        if(!empty($request->category)){
            $jobs=$jobs->where('category_id',$request->category);
        }
         //search using job type
         $jobTypeArray=[];
         if(!empty($request->job_type)){
            $jobTypeArray=explode(',',$request->job_type);
            $jobs=$jobs->whereIn('job_type_id',$jobTypeArray);
        }
        //search using experience
        if(!empty($request->experience)){
            $jobs=$jobs->where('experience',$request->experience);
        }

        $jobs=$jobs->with(['jobType','category']);

        if(isset($request->sort) && $request->sort=='0'){
            $jobs=$jobs->orderBy('created_at','ASC');

        }else{
         $jobs=$jobs->orderBy('created_at','DESC');
        }
        $jobs=$jobs->paginate(9);


        return view('front.jobs',[
            'categories'=>$categories,
            'jobTypes'=>$jobTypes,
            'jobs'=>$jobs,
            'jobTypeArray'=>$jobTypeArray
        ]);
    }
    public function detail($id){
        $job=Job::where(['id'=>$id,'status'=>1])
        ->with(['jobType','category'])->first();
        if($job==null){
            abort(404);
        }

        //check if user already saved the job
        $countSavedJob='';
        if(Auth::check()){
            $countSavedJob=SavedJob::where([
                'user_id'=>Auth::user()->id,
                'job_id'=>$id
            ])->count();
        }
        

        return view('front.jobDetail',compact('job','countSavedJob'));
    }
    public function applyJob(Request $request){
        $id=$request->id;
        $job=Job::where('id',$id)->first();

        //If Job not found in DB
        if($job==null){
            $message='Job does not exit';
            session()->flash('error',$message);
            return response()->json([
                'status'=>false,
                'message'=>$message
            ]);
        }
        //You can not apply on your job
        $employer_id=$job->user_id;
        if($employer_id==Auth::user()->id){
            $message='You can not apply own your job';
            session()->flash('error',$message);
            return response()->json([
                'status'=>false,
                'message'=> $message
            ]);

        }
        //You can not apply on a job twise
        $jobApplicationCount=JobApplication::where([
            'user_id'=>Auth::user()->id,
            'job_id'=>$id
        ])->count();

        if($jobApplicationCount>0){
            $message='You already applied on this job';
            session()->flash('error',$message);
            return response()->json([
                'status'=>false,
                'message'=> $message
            ]);
        }

        $application=new JobApplication();
        $application->job_id=$id;
        $application->user_id=Auth::user()->id;
        $application->employer_id=$employer_id;
        $application->applied_date=now();
        $application->save();

        //Send notification email to employer

        $employer=User::where('id',$employer_id)->first();
        $mailData=[
            'employer'=>$employer,
            'user'=>Auth::user(),
            'job'=>$job,
        ];

        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

        $message='You have successfully applied.';
        session()->flash('success',$message);
            return response()->json([
                'status'=>true,
                'message'=>$message
            ]);
    }
    public function savedJob(Request $request){
        $id=$request->id;
        $job=Job::find($id);
        if($job==null){
            session()->flash('error','Job not found!!');
            return response()->json([
                'status'=>false,
            ]);
        }
        //check if user already saved the job
        $countSavedJob=SavedJob::where([
            'user_id'=>Auth::user()->id,
            'job_id'=>$id
        ])->count();
        if($countSavedJob>0){
            session()->flash('error','Job already saved on this job');
            return response()->json([
                'status'=>false,
            ]);
        }
        $savedJob=new SavedJob;
        $savedJob->job_id=$id;
        $savedJob->user_id=Auth::user()->id;
        $savedJob->save();

        session()->flash('success','You have successfully saved this job');
        return response()->json([
            'status'=>true,
        ]);
    }
    
}