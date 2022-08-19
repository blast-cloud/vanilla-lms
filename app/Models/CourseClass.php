<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="CourseClass",
 *      required={"code", "name", "credit_hours"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="code",
 *          description="code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email_address",
 *          description="email_address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="telephone",
 *          description="telephone",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="location",
 *          description="location",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="monday_time",
 *          description="monday_time",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="tuesday_time",
 *          description="tuesday_time",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="wednesday_time",
 *          description="wednesday_time",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="thursday_time",
 *          description="thursday_time",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="friday_time",
 *          description="friday_time",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="saturday_time",
 *          description="saturday_time",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="sunday_time",
 *          description="sunday_time",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="credit_hours",
 *          description="credit_hours",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="next_lecture_date",
 *          description="next_lecture_date",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="next_exam_date",
 *          description="next_exam_date",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="outline",
 *          description="outline",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="course_id",
 *          description="course_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="semester_id",
 *          description="semester_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="department_id",
 *          description="department_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="lecturer_id",
 *          description="lecturer_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class CourseClass extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'course_classes';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'code',
        'name',
        'email_address',
        'telephone',
        'location',
        'monday_time',
        'tuesday_time',
        'wednesday_time',
        'thursday_time',
        'friday_time',
        'saturday_time',
        'sunday_time',
        'credit_hours',
        'next_lecture_date',
        'next_exam_date',
        'outline',
        'course_id',
        'semester_id',
        'department_id',
        'lecturer_id',
        'level'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string',
        'email_address' => 'string',
        'telephone' => 'string',
        'location' => 'string',
        'monday_time' => 'string',
        'tuesday_time' => 'string',
        'wednesday_time' => 'string',
        'thursday_time' => 'string',
        'friday_time' => 'string',
        'saturday_time' => 'string',
        'sunday_time' => 'string',
        'credit_hours' => 'integer',
        'next_lecture_date' => 'string',
        'next_exam_date' => 'string',
        'outline' => 'string',
        'course_id' => 'integer',
        'semester_id' => 'integer',
        'department_id' => 'integer',
        'lecturer_id' => 'integer',
        'level' => 'integer'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function lecturer()
    {
        return $this->hasOne(\App\Models\Lecturer::class, 'id', 'lecturer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function course()
    {
        return $this->hasOne(\App\Models\Course::class, 'id', 'course_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function semester()
    {
        return $this->hasOne(\App\Models\Semester::class, 'id', 'semester_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function department()
    {
        return $this->hasOne(\App\Models\Department::class, 'id', 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function announcements()
    {
        return $this->hasMany(\App\Models\Announcement::class, 'course_class_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function classMaterials()
    {
        return $this->hasMany(\App\Models\ClassMaterial::class, 'course_class_id');
    }
    public function studentClassActivity()
    {
        return $this->hasMany(\App\Models\StudentClassActivity::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function grades()
    {
        return $this->hasMany(\App\Models\Grade::class, 'course_class_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function enrollments()
    {
        return $this->hasOne(\App\Models\Enrollment::class, 'course_class_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function submissions()
    {
        return $this->hasMany(\App\Models\Submission::class, 'course_class_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function forums()
    {
        return $this->hasMany(\App\Models\Forum::class, 'course_class_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function calendarEntries()
    {
        return $this->hasMany(\App\Models\CalendarEntry::class, 'course_class_id');
    }

    public function getCourseClasslecturers(){ 

         return CourseClass::where('course_id',$this->course_id)->where('semester_id',$this->semester_id)->get();
    }
}
