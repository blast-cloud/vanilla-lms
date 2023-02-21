<?php

namespace App\Repositories;

use App\Models\SemesterMaxCreditLoad;
use App\Repositories\BaseRepository;

class SemesterMaxCreditLoadRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'level',
        'semester_code',
        'max_credit_load',
        'department_id'
    ];

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return SemesterMaxCreditLoad::class;
    }
}
