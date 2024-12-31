<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //This method will show our home page
    public function index(){
       $categories= Category::where('status',1)->orderBy('name','ASC')->take(8)->get();

        $new_categories= Category::where('status',1)->orderBy('name','ASC')->get();
        $featuredjobs=Job::where('status',1)
            ->orderBy('created_at','DESC')
            ->with('jobType')
            ->where('isFeatured',1)->take(6)->get();

        $latestedjobs=Job::where('status',1)
            ->orderBy('created_at','DESC')
            ->with('jobType')
            ->take(6)->get();
      return view ('front.home',compact('categories','latestedjobs','featuredjobs','new_categories'));
    }
    //This method will show our home page
    public function contact(){
        return view ('front.contact');
      }
}
