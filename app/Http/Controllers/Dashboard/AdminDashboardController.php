<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AnnouncementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Repositories\AnnouncementRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Request;

class AdminDashboardController extends AppBaseController
{

    public function index(Request $request)
    {
        return view("dashboard.admin.index");
    }



}

?>