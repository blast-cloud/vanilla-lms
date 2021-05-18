<?php

namespace App\Repositories;

use App\Models\CalendarEntry;
use App\Repositories\BaseRepository;

/**
 * Class CalendarEntryRepository
 * @package App\Repositories
 * @version May 18, 2021, 4:57 am UTC
*/

class CalendarEntryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'description'
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
        return CalendarEntry::class;
    }
}
