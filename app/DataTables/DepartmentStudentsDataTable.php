<?php

namespace App\DataTables;

use App\Models\Student;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;


class DepartmentStudentsDataTable extends StudentDataTable
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
        $dataTable->addColumn('matriculation_number', function ($query) {
            $link = route('dashboard.manager.student-page',$query->id);
            $message = $query->has_graduated ? "<h6 class='text-danger'> graduated </h6>" : "<h6 class='text-success'> active student </h6>";
            return "<a href='{$link}' class='call_telefonos' style='color:blue;' title='Manage $query->matriculation_number'><u>$query->matriculation_number</u></a><br>'$message'";
        })->filterColumn('matriculation_number', function ($query, $keyword) {
           
            $query->whereRaw("matriculation_number like ?", ["%{$keyword}%"]);
         })->orderColumn('matriculation_number', function ($query, $order) {
            $query->orderBy('matriculation_number', $order);
        });
        $dataTable->addColumn('full_name', function ($query) {
            return "{$query->first_name} {$query->last_name}";
        })->filterColumn('full_name', function ($query, $keyword) {
            $keywords = trim($keyword);
            $query->whereRaw("CONCAT(first_name, last_name) like ?", ["%{$keywords}%"]);
         })->orderColumn('full_name', function ($query, $order) {
            $query->orderBy('first_name',$order);
        });

        $dataTable->addColumn('level', function ($query) {
            return "{$query->level}";
        });

        $dataTable->addColumn('action', 'students.datatables_actions');
        $dataTable->rawColumns(['matriculation_number','action']);

        return $dataTable;
    }    

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        // return [
        //     'matriculation_number',
        //     'email',
        //     'full_name',
        //     'telephone'
        // ];

        return [
            Column::make('matriculation_number')
                ->addClass('text-left')
                ->width(200)
            ,
            Column::make('email')
            ,
            Column::make('full_name')
                ->addClass('text-right')
            ,
            Column::make('sex')
                ->addClass('text-center')
            ,
            Column::make('level')
            ->addClass('text-center')
            ,
            Column::make('telephone')
                ->addClass('text-right')
                ->width(80)
            // ,
            // Column::computed('action')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(100)
            //     ->addClass('text-center')
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Student $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Student $model)
    {
        return Student::where("department_id", $this->department_id)
                            ->select("students.*");
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
            ->addAction(['width' => '130px', 'printable' => false])
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

}
