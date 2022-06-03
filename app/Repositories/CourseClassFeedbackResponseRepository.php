<?php

namespace App\Repositories;

use App\Models\CourseClassFeedbackResponse;
use App\Repositories\BaseRepository;


class CourseClassFeedbackResponseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'note',
        'course_class_feedback_id',
        'course_class_id',
        'student_id',
        'lecturer_id',
        'department_id',
        'semester_id'
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
        return CourseClassFeedbackResponse::class;
    }
}
