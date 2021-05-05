<?php

namespace App\Repositories;

use App\Models\Manager;
use App\Repositories\BaseRepository;

/**
 * Class ManagerRepository
 * @package App\Repositories
 * @version May 5, 2021, 2:52 pm UTC
*/

class ManagerRepository extends BaseRepository
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
        'picture_file_path'
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
        return Manager::class;
    }
}
