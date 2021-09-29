<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentClassActivity extends Model
{
    use HasFactory;
    

    public $fillable = [
        'student_id',
        'course_class_id',
        'class_material_id',
        'clicked',
        'downloaded',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    public $casted = [
        'student_id'=> 'integer',
        'course_class_id' => 'integer',
        'class_material_id' => 'integer',
        'clicked' => 'boolean',
        'downloaded' => 'boolean',
    ];


    public function student()
    {           
        return $this->belongsToMany(Student::class, 'student_id', 'id');
    }
    public function courseClass()
    {           
        return $this->belongsToMany(CourseClass::class, 'course_class_id', 'id');
    }
    public function classMaterial()
    {           
        return $this->belongsToMany(ClassMaterial::class, 'class_material_id', 'id');
    }
    
}
