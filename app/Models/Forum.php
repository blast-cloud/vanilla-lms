<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Forum",
 *      required={"group_name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="group_name",
 *          description="group_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="posting",
 *          description="posting",
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
 *          property="student_id",
 *          description="student_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="course_class_id",
 *          description="course_class_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="parent_forum_id",
 *          description="parent_forum_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Forum extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'forums';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'group_name',
        'posting',
        'student_id',
        'course_class_id',
        'parent_forum_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'group_name' => 'string',
        'posting' => 'string',
        'student_id' => 'integer',
        'course_class_id' => 'integer',
        'parent_forum_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'group_name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function student()
    {
        return $this->hasOne(\App\Models\Student::class, 'id', 'student_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function courseClass()
    {
        return $this->hasOne(\App\Models\CourseClass::class, 'id', 'course_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function forum()
    {
        return $this->hasOne(\App\Models\Forum::class, 'id', 'parent_forum_id');
    }
}
