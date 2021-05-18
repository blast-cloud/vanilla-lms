<?php

namespace App\Repositories;

use App\Models\Submission;
use App\Repositories\BaseRepository;

/**
 * Class SubmissionRepository
 * @package App\Repositories
 * @version May 18, 2021, 5:07 am UTC
*/

class SubmissionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'upload_file_path',
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
        return Submission::class;
    }
}
