<?php

namespace App\DataTables;

use App\Models\CourseClass;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class DepartmentClassScheduleDataTable extends CourseClassDataTable
{
    
    protected $department_id;

    public function __construct($department_id){
        $this->department_id = $department_id;
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
        $dataTable->addColumn('lecturer', function ($query) {
            if ($query->lecturer != null){
                return "{$query->lecturer->first_name} {$query->lecturer->last_name} ({$query->lecturer->job_title})";
            }
            return "None Assigned";
        });

        $dataTable->addColumn('academic_session', function ($query) {
            if ($query->semester != null){
                return "{$query->semester->academic_session}";
            }
            return "None Assigned";
        });

        $dataTable->addColumn('semester', function ($query) {
            if ($query->semester != null){
                return "{$query->semester->code}";
            }
            return "None Assigned";
        });
        
        return $dataTable->addColumn('action', 'course_classes.datatables_actions');
    }    

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CourseClass $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CourseClass $model)
    {
        return CourseClass::where("department_id", $this->department_id)
                            ->select("course_classes.*");
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
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    // ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
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
            'code',
            ['title' => 'Course Title', 'data' => 'name'],
            'lecturer',
            'academic_session',
            'semester',
            'level',
            'credit_hours'
        ];
    }
}
