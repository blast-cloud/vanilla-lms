<?php

namespace App\DataTables;

use App\Models\BroadcastNotification;
use App\Models\Semester;
//use App\Models\Semester;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class SemesterNotificationsDatatable extends DataTable
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
        $dataTable->editColumn('admin_receives', function ($query) {
            $receiversVar = "";
            if($query->managers_receives == 1){   $receiversVar .= "All Managers<br>"; }
            if ($query->lecturers_receives == 1) { $receiversVar .= "All Lecturers<br>"; }
            if ($query->students_receives == 1) { $receiversVar .= "All Students<br>"; } 
            if ($query->managers_receives == 0 && $query->lecturers_receives == 0 && $query->students_receives == 0) { $receiversVar .= " Nil<br>"; }
            return $receiversVar;
        })->escapeColumns('active')->make(true);

        $dataTable->editColumn('broadcast_status', function ($query) {
            if($query->broadcast_status == 1){ 
                return "<font color='green'>Broadcasted!</font>";
            } else if($query->broadcast_status == 0) { 
                return "<font color='red'>Not broadcasted!</font>"; 
            }
        })->escapeColumns('active')->make(true);

        $dataTable->editColumn('created_at', function ($query) {
            return date('(D) d-M-Y', strtotime($query->created_at));
        })->escapeColumns('active')->make(true);
        
        return $dataTable->addColumn('action', 'semesters.notification_datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BroadcastNotification $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BroadcastNotification $model)
    {
        //return $model->newQuery();
        $current_semester = Semester::where('is_current',true)->first();

        return $model->where('semester_id', optional($current_semester)->id);
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
                'order'     => [[3, 'desc']],
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
            ['title'=>'Subject','data'=>"title"],
            ['title'=>'Broadcast to','data'=>"admin_receives"],
            'broadcast_status',
            ['title'=>'Created on','data'=>"created_at"],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'semesters_notification_datatable_' . time();
    }
}
