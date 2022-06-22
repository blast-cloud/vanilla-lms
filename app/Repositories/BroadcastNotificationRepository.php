<?php

namespace App\Repositories;

use App\Models\BroadcastNotification;
use App\Repositories\BaseRepository;

/**
 * Class BroadcastNotificationRepository
 * @package App\Repositories
 * @version May 18, 2021, 5:07 am UTC
*/

class BroadcastNotificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'semester_id',
        'title',
        'message',
        'admin_receives',
        'managers_receives',
        'lecturers_receives',
        'students_receives',
        'broadcast_status',
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
        return BroadcastNotification::class;
    }
}
