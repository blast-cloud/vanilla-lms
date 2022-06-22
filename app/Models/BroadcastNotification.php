<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BroadcastNotification extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'broadcast_notifications';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'title',
        'message',
        'admin_receives',
        'semester_id',
        'managers_receives',
        'lecturers_receives',
        'students_receives',
        'broadcast_status',
        'scheduled_date',
        'scheduled_time',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'semester_id' => 'integer',
        'title' => 'string',
        'message' => 'string',
        'admin_receives' => 'integer',
        'managers_receives' => 'integer',
        'lecturers_receives' => 'integer',
        'students_receives' => 'integer',
        'broadcast_status' => 'integer',
        'scheduled_date' => 'date',
        //'scheduled_time' => 'time',
    ];
}
