<?php

namespace App\DataTables;

use App\Models\Enrollment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;


class DepartmentStudentEnrollmentDataTable extends EnrollmentDataTable
{
    protected $student_id;

    public function __construct($student_id){
        $this->student_id = $student_id;
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $dataTable->addColumn('Course', function ($query) {
            if ($query->courseClass != null){
                $link = route('dashboard.class',$query->course_class_id);
                $course_name = "{$query->courseClass->code} :: {$query->courseClass->name}";
                return "<a href='{$link}'>$course_name</a>";
            }
            return "N/A";
        });
        $dataTable->addColumn('Lecturer', function ($query) {
            if ($query->courseClass != null){
                return "{$query->courseClass->lecturer->first_name} {$query->courseClass->lecturer->last_name} ({$query->courseClass->lecturer->job_title})";
            }
            return "N/A";
        });

        $dataTable->addColumn('action', 'acl.partials.datatables_actions');

        // $dataTable->addColumn('action', 'calendar_entries.datatables_actions');
        $dataTable->rawColumns(['Course','action']);

        return $dataTable;
    } 

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('Course')
                ->addClass('text-left')
                ->width(400),
            Column::make('Lecturer'),
            // Column::make('Department')
            //     ->addClass('text-right')
            // ,
            /*Column::make('status')
                ->addClass('text-right')
                ->width(80),*/
                Column::make('action')
                ->addClass('text-right')
                ->width(80)
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Enrollment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Enrollment $model)
    {
        return Enrollment::where("student_id", $this->student_id);
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
            //->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    // ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    // ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    // ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    // ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    // ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }        

}
