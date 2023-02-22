<?php

namespace App\DataTables;

use App\Models\SemesterMaxCreditLoad;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class SemesterMaxCreditLoadDataTable extends DataTable
{
   
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'credit_loads.datatables_actions');

    }

    
    public function query(SemesterMaxCreditLoad $model)
    {
        $current_user = Auth()->user();
        if($current_user->manager_id != null){
            return $model->where('department_id',$current_user->department_id);
        }
        return $model->newQuery();
    }

   
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    /* ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',], */
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner mt-5 ml-5 dt-btn-w',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner mt-5 ml-5 dt-btn-w',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner mt-5 ml-5 dt-btn-w',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner mt-5 ml-5 dt-btn-w',],
                ],
            ]);
    }

   
    protected function getColumns()
    {
        return [
            'semester_code',
            'level',
            'max_credit_load'
        ];
    }

    
    protected function filename()
    {
        return 'semesters_max_credit_load_datatable_' . time();
    }
}
