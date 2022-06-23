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
use App\Notifications\BroadcastSemesterNotification;
use Notification;

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
        //$semester = $this->broadcastNotificationRepository->create($input);
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
        
        return $this->broadcastNotificationTo($eligible_receivers, $input);
        //return redirect(route('semesters.index'));  
    }

    public function broadcastNotificationTo($receivers, $input){ 
        if (count($receivers) === 1) {
            foreach ($receivers as $key) {
                if ($key == 'managers_receives') {
                    $users = User::where('manager_id', '!=', null)->get();
                } elseif ($key == 'lecturers_receives') {
                    $users = User::where('lecturer_id', '!=', null)->get();
                } elseif ($key == 'students_receives') {
                    $users = User::where('student_id', '!=', null)->get();
                }
            }
        } elseif (count($receivers) === 2) {
            $guide1 = [];
            $guide2 = [];
            //first item
            switch ($receivers[0]) {
              case 'managers_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['manager_id', '!=', null];
                } else {
                    $guide2 = ['manager_id', '!=', null];
                }
                break;
              case 'lecturers_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['lecturer_id', '!=', null];
                } else {
                    $guide2 = ['lecturer_id', '!=', null];
                }
                break;
              case 'students_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['student_id', '!=', null];
                } else {
                    $guide2 = ['student_id', '!=', null];
                }
                break;
            }
            //second item
            switch ($receivers[1]) {
              case 'managers_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['manager_id', '!=', null];
                } else {
                    $guide2 = ['manager_id', '!=', null];
                }
                break;
              case 'lecturers_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['lecturer_id', '!=', null];
                } else {
                    $guide2 = ['lecturer_id', '!=', null];
                }
                break;
              case 'students_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['student_id', '!=', null];
                } else {
                    $guide2 = ['student_id', '!=', null];
                }
                break;
            }
            $users = $this->twoGuides($guide1, $guide2);
        } elseif (count($receivers) === 3) {
            $guide1 = [];
            $guide2 = [];
            $guide3 = [];
            //first item
            switch ($receivers[0]) {
              case 'managers_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['manager_id', '!=', null];
                } elseif (count($guide2) == 0){
                    $guide2 = ['manager_id', '!=', null];
                } else {
                    $guide3 = ['manager_id', '!=', null];
                }
                break;
              case 'lecturers_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['lecturer_id', '!=', null];
                } elseif (count($guide2) == 0){
                    $guide2 = ['lecturer_id', '!=', null];
                } else {
                    $guide3 = ['lecturer_id', '!=', null];
                }
                break;
              case 'students_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['student_id', '!=', null];
                } elseif (count($guide2) == 0){
                    $guide2 = ['student_id', '!=', null];
                } else {
                    $guide3 = ['student_id', '!=', null];
                }
                break;
            }
            //second item
            switch ($receivers[1]) {
              case 'managers_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['manager_id', '!=', null];
                } elseif (count($guide2) == 0){
                    $guide2 = ['manager_id', '!=', null];
                } else {
                    $guide3 = ['manager_id', '!=', null];
                }
                break;
              case 'lecturers_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['lecturer_id', '!=', null];
                } elseif (count($guide2) == 0){
                    $guide2 = ['lecturer_id', '!=', null];
                } else {
                    $guide3 = ['lecturer_id', '!=', null];
                }
                break;
              case 'students_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['student_id', '!=', null];
                } elseif (count($guide2) == 0){
                    $guide2 = ['student_id', '!=', null];
                } else {
                    $guide3 = ['student_id', '!=', null];
                }
                break;
            }
            //third item
            switch ($receivers[2]) {
              case 'managers_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['manager_id', '!=', null];
                } elseif (count($guide2) == 0){
                    $guide2 = ['manager_id', '!=', null];
                } else {
                    $guide3 = ['manager_id', '!=', null];
                }
                break;
              case 'lecturers_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['lecturer_id', '!=', null];
                } elseif (count($guide2) == 0){
                    $guide2 = ['lecturer_id', '!=', null];
                } else {
                    $guide3 = ['lecturer_id', '!=', null];
                }
                break;
              case 'students_receives':
                if (count($guide1) == 0) {
                    $guide1 = ['student_id', '!=', null];
                } elseif (count($guide2) == 0){
                    $guide2 = ['student_id', '!=', null];
                } else {
                    $guide3 = ['student_id', '!=', null];
                }
                break;
            }
            $users = $this->threeGuides($guide1, $guide2, $guide3);
        }

        Notification::send($users, new BroadcastSemesterNotification($users, $input));
        return $users;
    }

    public function twoGuides($guide1, $guide2){
        return User::where([$guide1])->orWhere([$guide2])->get();
    }

    public function threeGuides($guide1, $guide2, $guide3){
        return User::where([$guide1])->orWhere([$guide2])->orWhere([$guide3])->get();
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
