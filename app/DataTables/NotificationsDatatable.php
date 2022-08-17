<?php

namespace App\DataTables;

use App\Models\BroadcastNotification;
//use App\Models\Semester;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class NotificationsDatatable extends DataTable
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
        $dataTable->editColumn('broadcast_to', function ($query) {
            $receiversVar = "";
            if($query->managers_receives == 1){   $receiversVar .= "All Managers<br>"; }
            if ($query->lecturers_receives == 1) { $receiversVar .= "All Lecturers<br>"; }
            if ($query->students_receives == 1) { $receiversVar .= "All Students<br>"; } 
            if ($query->managers_receives == 0 && $query->lecturers_receives == 0 && $query->students_receives == 0) { $receiversVar .= " Nil<br>"; }
            return $receiversVar;
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
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[3, 'desc']],
                'buttons'   => [
                    /* ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',], */
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
            ['title'=>'Subject','data'=>"title"],
            Column::make('broadcast_to'),
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
        return 'notification_datatable_' . time();
    }
}
