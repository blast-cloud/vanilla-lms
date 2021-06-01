<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Grade",
 *      required={"grade_title"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="grade_title",
 *          description="grade_title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="score",
 *          description="score",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="grade_letter",
 *          description="grade_letter",
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
class Grade extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'grades';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'grade_title',
        'score',
        'grade_letter',
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
        'grade_title' => 'string',
        'score' => 'integer',
        'grade_letter' => 'string',
        'student_id' => 'integer',
        'course_class_id' => 'integer',
        'class_material_id' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function student()
    {
        return $this->hasOne(\App\Models\Student::class, 'student_id', 'id');
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
        return $this->hasMany(\App\Models\ClassMaterial::class, 'class_material_id', 'id');
    }

    public function submission()
    {
        return $this->hasOne(Submission::class, 'grade_id', 'id');
    }
}
