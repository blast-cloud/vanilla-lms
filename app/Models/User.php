<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'telephone',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'first_name',
        'last_name',
        'matric_number'
    ];

    public function getFirstNameAttribute()
    {
        if ($this->manager_id != null){
            return $this->manager->first_name;

        }else if ($this->student_id != null){
            return $this->student->first_name;
    
        }else if ($this->lecturer_id != null){
            return $this->lecturer->first_name;

        }else if ($this->is_platform_admin != null){
            return "Platform";
        }
        return "N/A";
    }

    public function getLastNameAttribute()
    {
        if ($this->manager_id != null){
            return $this->manager->last_name;

        }else if ($this->student_id != null){
            return $this->student->last_name;
    
        }else if ($this->lecturer_id != null){
            return $this->lecturer->last_name;

        }else if ($this->is_platform_admin != null){
            return "Administrator";
        }
        return "N/A";
    }

    public function getMatricNumberAttribute()
    {
        if ($this->student_id != null){
            return $this->student->matriculation_number;
        }
        return "N/A";
    }

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
    public function student()
    {
        return $this->hasOne(\App\Models\Student::class, 'id', 'student_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function manager()
    {
        return $this->hasOne(\App\Models\Manager::class, 'id', 'manager_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function department()
    {
        return $this->hasOne(\App\Models\Department::class, 'id', 'department_id');
    }    

}
