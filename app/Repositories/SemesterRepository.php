<?php

namespace App\Repositories;

use App\Models\Semester;
use App\Repositories\BaseRepository;

/**
 * Class SemesterRepository
 * @package App\Repositories
 * @version May 18, 2021, 5:07 am UTC
*/

class SemesterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'code',
        'start_date',
        'end_date',
        'is_current',
        'academic_session',
        'status',
        'unique_code'
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
        return Semester::class;
    }
}
