<?php

namespace App\Repositories;

use App\Models\CourseClassFeedback;
use App\Repositories\BaseRepository;


class CourseClassFeedbackRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'note',
        'department_id',
        'course_class_id',
        'creator_user_id'
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
        return CourseClassFeedback::class;
    }
}
