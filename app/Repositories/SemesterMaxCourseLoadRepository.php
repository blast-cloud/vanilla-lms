<?php

namespace App\Repositories;

use App\Models\SemesterMaxCreditLoad;
use App\Repositories\BaseRepository;

/**
 * Class SemesterRepository
 * @package App\Repositories
 * @version May 18, 2021, 5:07 am UTC
*/

class SemesterMaxCourseLoadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'level',
        'semester_code',
        'max_credit_load',
        'department_id'
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
        return SemesterMaxCreditLoad::class;
    }
}
