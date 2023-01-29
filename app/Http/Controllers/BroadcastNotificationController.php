<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BroadcastNotificationRequest;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\BroadcastNotification;
use Flash;
use App\Models\CourseClass;
use App\Http\Resources\BroadcastNotificationResource;
use App\Repositories\BroadcastNotificationRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\CourseClassRepository;
use App\DataTables\NotificationsDatatable;
use App\Jobs\BroadcastNotificationJob;
/*use Notification;*/

use App\Models\User;

class BroadcastNotificationController extends AppBaseController
{
    /** @var  BroadcastNotificationRepository */
    private $broadcastNotificationRepository;

    /** @var  CourseClassRepository */
    private $courseClassRepository;

    /** @var  EnrollmentRepository */
    private $enrollmentRepository;


    public function __construct(BroadcastNotificationRepository $broadcastNotificationRepo,
                                      CourseClassRepository $courseClassRepo,
                                      EnrollmentRepository $enrollmentRepo)
    {
        $this->broadcastNotificationRepository = $broadcastNotificationRepo;
        $this->courseClassRepository = $courseClassRepo;
        $this->enrollmentRepository = $enrollmentRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NotificationsDatatable $NotificationsDatatable)
    {
        $current_user = Auth()->user();

        $current_semester = \App\Models\Semester::where('is_current', 1)->first();

        $class_schedules = $this->courseClassRepository->all(['department_id'=>$current_user->department_id],null, 10);

        if($current_user->student_id != null){
            $enrollment_ids = [];
            $enrollments = $this->enrollmentRepository->all(['student_id'=>$current_user->student_id]);
            foreach ($enrollments as $item){
                $enrollment_ids []= $item->course_class_id;
            }
            $class_schedules = CourseClass::with('enrollments')->findMany($enrollment_ids)->where('semester_id',optional($current_semester)->id)
            ->where('department_id',$current_user->department_id);

        }elseif($current_user->lecturer_id != null){
            $class_schedules = $this->courseClassRepository->all([
                'department_id' => $current_user->department_id,
                'lecturer_id'=>$current_user->lecturer_id,
                'semester_id' => optional($current_semester)->id
            ]);
        }

        return $NotificationsDatatable->with('current_semester', $current_semester)->render('semesters.category_notifications', ['current_semester' => $current_semester, 'class_schedules' => $class_schedules]);
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
        //Flash::success('Notification saved and broadcated successfully.');

        //Broadcast  method
        return $this->broadcastNotificationTo($input, $broadcastNotificationID);
    }

    public function broadcastNotificationTo($input, $broadcastNotificationID){ 

        $users = User::where(function ($query) use ($input) {
                if ($input['managers_receives'] == '1') {
                    $query->whereNotNull('manager_id')
                    ->where('is_disabled', false);
                }
            })
            ->orWhere(function ($query) use ($input) {
                if ($input['lecturers_receives'] == '1') {
                    $query->whereNotNull('lecturer_id')
                    ->where('is_disabled', false);
                }
            })
            ->orWhere(function ($query) use ($input) {
                if ($input['students_receives'] == '1') {
                    $query->whereNotNull('student_id')
                    ->where('is_disabled', false);
                }
            }) 
            ->get();
        
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
