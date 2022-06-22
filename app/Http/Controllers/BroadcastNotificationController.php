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

//use App\Events\SemesterCreated;

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
        $semester = $this->broadcastNotificationRepository->create($input);
        Flash::success('Notification saved successfully.');   
        return redirect(route('semesters.index'));  
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
