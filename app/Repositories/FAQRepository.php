<?php

namespace App\Repositories;

use App\Models\FAQ;
use App\Repositories\BaseRepository;

/**
 * Class FAQRepository
 * @package App\Repositories
 * @version August 24, 2021, 11:17am WAT
*/

class FAQRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'question',
        'answer'
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
        return FAQ::class;
    }
}