<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Department",
 *      required={"code", "name"},
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
 *          property="website_url",
 *          description="website_url",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email_address",
 *          description="email_address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="contact_phone",
 *          description="contact_phone",
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
 *      )
 * )
 */
class Department extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'departments';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'code',
        'name',
        'website_url',
        'email_address',
        'contact_phone'
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
        'website_url' => 'string',
        'email_address' => 'string',
        'contact_phone' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required',
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function courses()
    {
        return $this->hasMany(\App\Models\Course::class, 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function courseClasses()
    {
        return $this->hasMany(\App\Models\CourseClass::class, 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function announcements()
    {
        return $this->hasMany(\App\Models\Announcement::class, 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function calendarEntries()
    {
        return $this->hasMany(\App\Models\CalendarEntry::class, 'course_class_id');
    }
}
