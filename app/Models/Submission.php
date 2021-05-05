<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Submission",
 *      required={"title"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="upload_file_path",
 *          description="upload_file_path",
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
 *          property="class_material_id",
 *          description="class_material_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Submission extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'submissions';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'upload_file_path',
        'student_id',
        'course_class_id',
        'class_material_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'upload_file_path' => 'string',
        'student_id' => 'integer',
        'course_class_id' => 'integer',
        'class_material_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required'
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
    public function classMaterial()
    {
        return $this->hasOne(\App\Models\ClassMaterial::class, 'id', 'class_material_id');
    }
}
