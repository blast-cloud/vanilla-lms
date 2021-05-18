<?php

namespace App\Repositories;

use App\Models\Lecturer;
use App\Repositories\BaseRepository;

/**
 * Class LecturerRepository
 * @package App\Repositories
 * @version May 18, 2021, 4:58 am UTC
*/

class LecturerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'email',
        'telephone',
        'job_title',
        'first_name',
        'last_name',
        'picture_file_path',
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
        return Lecturer::class;
    }
}
