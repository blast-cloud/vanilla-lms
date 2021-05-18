<?php

namespace App\Repositories;

use App\Models\Grade;
use App\Repositories\BaseRepository;

/**
 * Class GradeRepository
 * @package App\Repositories
 * @version May 18, 2021, 4:58 am UTC
*/

class GradeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'grade_title',
        'grade_letter',
        'student_id',
        'course_class_id',
        'class_material_id'
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
        return Grade::class;
    }
}
