<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseClassFeedback extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'course_class_feedbacks';
    

    protected $dates = ['deleted_at'];
    

    public $fillable = [
        'note',
        'start_date',
        'end_date',
        'department_id',
        'course_class_id',
        'creator_user_id'     
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'note' => 'string',
        'start_date' => 'string',
        'end_date' => 'string',
        'department_id' => 'integer',
        'course_class_id' => 'integer',
        'creator_user_id' => 'integer'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/

    public function courseClass()
    {
        return $this->hasOne(\App\Models\CourseClass::class,  'course_id', 'id');
    }

    public function department()
    {
        return $this->hasOne(\App\Models\Department::class, 'department_id', 'id');
    }

    public function courseFeedbackResponse()
    {
        return $this->hasMany(CourseClassFeedbackResponse::class, 'course_class_feedback_id', 'id');
    }
   
}
