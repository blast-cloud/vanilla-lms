<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BroadcastNotificationRequest;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\BroadcastNotification;
use Flash;
use App\Http\Resources\BroadcastNotificationResource;
use App\Repositories\BroadcastNotificationRepository;
use App\DataTables\SemesterNotificationsDatatable;
use App\Jobs\BroadcastNotificationJob;
/*use Notification;*/

use App\Models\User;

class BroadcastNotificationController extends AppBaseController
{
    /** @var  BroadcastNotificationRepository */
    private $broadcastNotificationRepository;

    public function __construct(BroadcastNotificationRepository $broadcastNotificationRepo)
    {
        $this->broadcastNotificationRepository = $broadcastNotificationRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BroadcastNotificationRequest $request)
    {
        $input = $request->all();
        $broadcastNotificationID = $this->broadcastNotificationRepository->create($input)->id;
        Flash::success('Notification saved and broadcated successfully.');

        //broadcast logic
        $eligible_receivers = [];
        $get_managers_receives_status = $input['managers_receives'];
        $get_lecturers_receives_status = $input['lecturers_receives'];
        $get_students_receives_status = $input['students_receives'];

        if ($get_managers_receives_status == 1) {
            array_push($eligible_receivers, 'managers_receives');
        }
        if ($get_lecturers_receives_status == 1) {
            array_push($eligible_receivers, 'lecturers_receives');
        }
        if ($get_students_receives_status == 1) {
            array_push($eligible_receivers, 'students_receives');
        }
        
        return $this->broadcastNotificationTo($eligible_receivers, $input, $broadcastNotificationID);
        //return redirect(route('semesters.index'));  
    }

    public function broadcastNotificationTo($eligible_receivers, $input, $broadcastNotificationID){ 
        $strArgs = '';
        $arrArgs = [];
        foreach ($eligible_receivers as $key) {
            if ($key == 'managers_receives') {
                if ($strArgs == '') {
                    $strArgs .= 'manager_id != ?';
                } else {
                    $strArgs .= ' or manager_id != ?';
                }
                array_push($arrArgs, 'null');
            } elseif ($key == 'lecturers_receives') {
                if ($strArgs == '') {
                    $strArgs .= 'lecturer_id != ?';
                } else {
                    $strArgs .= ' or lecturer_id != ?';
                }
                array_push($arrArgs, 'null');
            } elseif ($key == 'students_receives') {
                if ($strArgs == '') {
                    $strArgs .= 'student_id != ?';
                } else {
                    $strArgs .= ' or student_id != ?';
                }
                array_push($arrArgs, 'null');
            }
        }
        
        $users = User::whereRaw("$strArgs", $arrArgs)->get();
        BroadcastNotificationJob::dispatch($users, $input);
        if (count($users) > 0) {
            $getNotification = BroadcastNotification::find($broadcastNotificationID);
            $getNotification->broadcast_status = 1;
            $getNotification->save();
        }
        return $this->sendResponse('', 'Notification broadcated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = $this->broadcastNotificationRepository->find($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        return $this->sendResponse(new BroadcastNotificationResource($notification), 'Notification retrieved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         /** @var Notification $notification */
        $notification = $this->broadcastNotificationRepository->find($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }
        
        return $this->sendResponse(new BroadcastNotificationResource($notification), 'Notification retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BroadcastNotificationRequest $request, $id)
    {
        $notification = $this->broadcastNotificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');
            return $this->sendError('Notification not found');
        }

        $notification = $this->broadcastNotificationRepository->update($request->all(), $id);

        Flash::success('Notification updated successfully.');
        return $this->sendResponse(new BroadcastNotificationResource($notification), 'Notification updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = $this->broadcastNotificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');
            return $this->sendError('Notification not found');
        }

        $this->broadcastNotificationRepository->delete($id);

        Flash::success('Notification deleted successfully.');

        //NotificationDeleted::dispatch($semester);
        return $this->sendResponse(new BroadcastNotificationResource($notification), 'Notification deleted successfully');    }
}
