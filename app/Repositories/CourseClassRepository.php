<?php

namespace App\Repositories;

use App\Models\CourseClass;
use App\Repositories\BaseRepository;

/**
 * Class CourseClassRepository
 * @package App\Repositories
 * @version May 5, 2021, 2:52 pm UTC
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
        'lecturer_id'
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
