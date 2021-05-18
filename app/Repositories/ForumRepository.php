<?php

namespace App\Repositories;

use App\Models\Forum;
use App\Repositories\BaseRepository;

/**
 * Class ForumRepository
 * @package App\Repositories
 * @version May 18, 2021, 5:07 am UTC
*/

class ForumRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'group_name',
        'posting',
        'student_id',
        'course_class_id',
        'parent_forum_id'
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
        return Forum::class;
    }
}
