<?php

namespace App\Repositories;

use App\Models\CourseClass;
use App\Repositories\BaseRepository;

/**
 * Class CourseClassRepository
 * @package App\Repositories
 * @version May 18, 2021, 5:07 am UTC
*/

class CourseClassRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'name',
        'email_address',
        'telephone',
        'location',
        'credit_hours',
        'semester_id',
        'department_id',
        'lecturer_id',
        'level'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CourseClass::class;
    }
}
