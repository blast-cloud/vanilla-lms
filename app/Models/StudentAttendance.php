<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    public $fillable = [
        'student_id',
        'course_class_id',
        'class_material_id',
        'photo_file_path'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
