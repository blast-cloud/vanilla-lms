<?php

namespace App\DataTables;

use App\Models\User;

use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UserAccountsDataTable extends DataTable
{

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {

        $matric_num = "";

        $dataTable = new EloquentDataTable($query);
        $dataTable->addColumn('full_name', function ($query) {

            $first_name = "";
            $last_name = "N/A";

            if ($query->student_id!=null && $query->student!=null){
                $first_name = $query->student->first_name;
                $last_name = $query->student->last_name;

            }elseif ($query->lecturer_id!=null && $query->lecturer!=null){
                $first_name = $query->lecturer->first_name;
                $last_name = $query->lecturer->last_name;

            }elseif ($query->manager_id!=null && $query->manager!=null){
                $first_name = $query->manager->first_name;
                $last_name = $query->manager->last_name;

            }elseif ($query->is_platform_admin!=null){
                $first_name = "System";
                $last_name = "Administrator";
            }

            return "{$first_name} {$last_name}";

        })->addColumn('type', function ($query) {
            
            $first_name = "System";
            $last_name = "Administrator";
            if ($query->student_id!=null){
                return "Student";
            }elseif ($query->lecturer_id!=null){
                return "Lecturer";
            }elseif ($query->manager_id!=null){
                return "Manager";
            }elseif ($query->is_platform_admin!=null){
                return "Administrator";
            }

            return "N/A";

        })->addColumn('disabled', function ($query) {
            if ($query->is_disabled){
                return "Yes";
            }
            return "No";
        });

        $dataTable->addColumn('department', function($query)
        {
            return $query->department ? $query->department->name:'N/A';
        });

        $dataTable->addColumn('action', 'acl.partials.user-account-action-buttons');
        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    //['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'full_name',
            'email',
            'telephone',
            // 'department',
            // 'job_title',
            'disabled',
            'type',
            'department',
            //'last_login_date'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'users_datatable_' . time();
    }

}
