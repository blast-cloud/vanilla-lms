<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseClassFeedbackResponse extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'course_class_feedback_responses';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'note',
        'assignments_rating_point',
        'clarification_rating_point',
        'examination_rating_point',
        'teaching_rating_point',
        'course_class_feedback_id',
        'course_class_id',
        'student_id',
        'lecturer_id',
        'department_id',
        'semester_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'note' => 'string',
        'assignments_rating_point' => 'string',
        'clarification_rating_point' => 'string',
        'examination_rating_point' => 'string',
        'teaching_rating_point' => 'string',
        'course_class_feedback_id' => 'integer',
        'course_class_id' => 'integer',
        'student_id' => 'integer',
        'lecturer_id' => 'integer',
        'department_id' => 'integer',
        'semester_id' => 'integer'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/

    public function lecturer()
    {
        return $this->hasOne(\App\Models\Lecturer::class, 'lecturer_id', 'id');
    }

    public function courseClass()
    {
        return $this->hasOne(\App\Models\Course::class, 'course_id', 'id');
    }

    public function courseFeedback()
    {
        return $this->belongsTo(\App\Models\CourseClassFeedback::class, 'course_class_feedback_id', 'id');

    }

    public function student()
    {
        return $this->hasOne(\App\Models\Student::class,  'student_id', 'id');     
    }

    public function semester()
    {
        return $this->hasOne(\App\Models\Semester::class,  'semester_id', 'id');
    }

    public function department()
    {
        return $this->hasOne(\App\Models\Department::class,  'department_id', 'id');
    }
   
}
