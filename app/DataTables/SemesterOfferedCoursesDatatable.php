<?php

namespace App\DataTables;

use App\Models\Semester;
use App\Models\CourseClass;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class SemesterOfferedCoursesDatatable extends DataTable
{ 
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('lecturer.first_name', function ($query) {
                return "<font color='red'>" . $query->lecturer->job_title . " " . $query->lecturer->last_name . " " . $query->lecturer->first_name . "</font>";
        })->escapeColumns('active')->make(true);

        $dataTable->editColumn('code', function ($query) {
                return "<font color='red'>" . $query->code . "</font>";
        })->escapeColumns('active')->make(true);

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CourseClass $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CourseClass $model)
    {
        return $model->with(['lecturer'])->where('semester_id', $this->semester_id);
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

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['title'=>'Course Code','data'=>"code"],
            ['title'=>'Course Title','data'=>'name', 'name'=>'name' ],
            ['title'=>'Assigned Lecturer','data'=>"lecturer.first_name"],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'semester_offered_courses_datatable_' . time();
    }
}
