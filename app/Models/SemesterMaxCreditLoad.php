<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SemesterMaxCreditLoad extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table = 'semesters_max_credit_load';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'level',
        'semester_code',
        'max_credit_load',
        'department_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'level' => 'integer',
        'semester_code' => 'string',
        'max_credit_load' => 'integer',
        'department_id' => 'integer'
    ];

    public function department()
    {
        return $this->hasOne(Department::class, 'department_id', 'id');
    }


}
