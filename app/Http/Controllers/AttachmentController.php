<?php

namespace App\Http\Controllers;

use App\DataTables\AnnouncementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Repositories\AnnouncementRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;


class AttachmentController extends AppBaseController
{
    
    public function uploadFile(Request $request){

        if ($request->file == null) {
            return $this->sendError('The file must be provided.');
        }

        $file_type = $request->file->getClientOriginalExtension();
        $rndFileName = time() . '.' . $file_type;
        $path = $request->file->move(public_path('uploads'), $rndFileName);

        return $this->sendSuccess([
            "uploads/{$rndFileName}",$file_type
        ]);
    }

}
