<?php

namespace App\DataTables;

use App\Models\Announcement;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class LectnStudAnnouncementsDataTable extends DataTable
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

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Announcement $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Announcement $model)
    {
        $current_user = Auth()->user();
        
        if($current_user->student_id != null || $current_user->lecturer_id != null){
            return $model->where('department_id',$current_user->department_id)
                            ->where('course_class_id',null)
                            ->where('announcement_end_date', ">=", date("Y-m-d", time()))
                            ->orWhere(function($query2){
                            $query2->where('department_id', null)
                                ->where('course_class_id', null)
                                ->where('announcement_end_date', ">=", date("Y-m-d", time()));
                            });
        }
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
           // ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
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
            'title',
            'description'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'announcements_datatable_' . time();
    }
}
