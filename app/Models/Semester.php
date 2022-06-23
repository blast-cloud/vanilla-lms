<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Semester",
 *      required={"code", "start_date", "end_date"},
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
 *          property="start_date",
 *          description="start_date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="end_date",
 *          description="end_date",
 *          type="string",
 *          format="date"
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
 *      )
 * )
 */
class Semester extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'semesters';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'academic_session',
        'code',
        'unique_code',
        'start_date',
        'end_date',
        'is_current',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'unique_code' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'integer',
        'is_current' => 'integer',
        'academic_session' => 'string'

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function courseClasses()
    {
        return $this->hasMany(\App\Models\CourseClass::class, 'semester_id');
    }
}
