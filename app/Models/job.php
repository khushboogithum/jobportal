<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job extends Model
{
    use HasFactory;
    protected $table = 'jobs';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'category_id', 'job_type_id', 'user_id', 'vacancy', 'salary', 'location', 'description', 'benefits', 'responsibility', 'qualifications', 'keywords', 'experience', 'company_name', 'company_location', 'company_website', 'status', 'isFeatured','created_at', 'updated_at'];


    public function jobType(){
        return $this->belongsTo(JobType::class);    //JobType model use
    }
    public function category(){
        return $this->belongsTo(Category::class);   //Category model use
    }
    public function applications(){
        return $this->hasMany(JobApplication::class);
    }
}
