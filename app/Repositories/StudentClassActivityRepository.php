<?php

namespace App\Repositories;

use App\Models\StudentClassActivity;
use App\Repositories\BaseRepository;

/**
 * Class StudentClassActivityRepository
 * @package App\Repositories
 * @version September 22, 2021, 9:07 pm UTC
*/

class StudentClassActivityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'student_id',
        'class_material_id',
        'course_class_id',
        'clicked',
        'downloaded'
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
        return StudentClassActivity::class;
    }
}
