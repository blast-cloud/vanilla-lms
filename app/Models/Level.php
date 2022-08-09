<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'levels';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'level'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'level' => 'integer'
    ];

    /**
     * The roles that belong to the Level
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

}
