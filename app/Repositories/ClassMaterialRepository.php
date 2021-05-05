<?php

namespace App\Repositories;

use App\Models\ClassMaterial;
use App\Repositories\BaseRepository;

/**
 * Class ClassMaterialRepository
 * @package App\Repositories
 * @version May 5, 2021, 2:51 pm UTC
*/

class ClassMaterialRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'title',
        'description',
        'lecture_number',
        'assignment_number',
        'upload_file_path'
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
        return ClassMaterial::class;
    }
}
