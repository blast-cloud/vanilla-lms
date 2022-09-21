<?php

namespace App\DataTables;

use App\Models\CalendarEntry;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class DepartmentCalendarEntryDataTable extends CalendarEntryDataTable
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
        $dataTable->addColumn('due_date', function ($query) {
            return $query->due_date->format("d-m-Y");
        });
        
        return $dataTable->addColumn('action', 'calendar_entries.datatables_actions');
    }    

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CalendarEntry $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CalendarEntry $model)
    {
        return CalendarEntry::where("department_id", $this->department_id)
                            ->select("calendar_entries.*")
                            ->orderBy('due_date', 'asc');
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
                    //['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner btn-sm no-corner mt-5 ml-5 dt-btn-w',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner btn-sm no-corner mt-5 ml-5 dt-btn-w',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner btn-sm no-corner mt-5 ml-5 dt-btn-w',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner btn-sm no-corner mt-5 ml-5 dt-btn-w',],
                ],
            ]);
    }        
}
