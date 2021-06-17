<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

/**
 * @SWG\Definition(
 *      definition="Lecturer",
 *      required={"first_name", "last_name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="telephone",
 *          description="telephone",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="job_title",
 *          description="job_title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="first_name",
 *          description="first_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="last_name",
 *          description="last_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="picture_file_path",
 *          description="picture_file_path",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="profile_external_url",
 *          description="profile_external_url",
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
 *          property="department_id",
 *          description="department_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Lecturer extends Model
{
    use SoftDeletes;

    use HasFactory, Notifiable;

    public $table = 'lecturers';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'email',
        'telephone',
        'job_title',
        'first_name',
        'last_name',
        'picture_file_path',
        'profile_external_url',
        'department_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'email' => 'string',
        'telephone' => 'string',
        'job_title' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'picture_file_path' => 'string',
        'profile_external_url' => 'string',
        'department_id' => 'integer'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'lecturer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function department()
    {
        return $this->hasOne(\App\Models\Department::class, 'id', 'department_id');
    }
}
