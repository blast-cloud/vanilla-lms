<?php

namespace App\Http\Controllers\API;

use App\Events\CalendarEntryCreated;
use App\Events\CalendarEntryUpdated;
use App\Events\CalendarEntryDeleted;

use App\Http\Requests\API\CreateCalendarEntryAPIRequest;
use App\Http\Requests\API\UpdateCalendarEntryAPIRequest;
use App\Models\CalendarEntry;
use App\Repositories\CalendarEntryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CalendarEntryResource;
use Response;

/**
 * Class CalendarEntryController
 * @package App\Http\Controllers\API
 */

class CalendarEntryAPIController extends AppBaseController
{
    /** @var  CalendarEntryRepository */
    private $calendarEntryRepository;

    public function __construct(CalendarEntryRepository $calendarEntryRepo)
    {
        $this->calendarEntryRepository = $calendarEntryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/calendarEntries",
     *      summary="Get a listing of the CalendarEntries.",
     *      tags={"CalendarEntry"},
     *      description="Get all CalendarEntries",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/CalendarEntry")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $calendarEntries = $this->calendarEntryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(CalendarEntryResource::collection($calendarEntries), 'Calendar Entries retrieved successfully');
    }

    /**
     * @param CreateCalendarEntryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/calendarEntries",
     *      summary="Store a newly created CalendarEntry in storage",
     *      tags={"CalendarEntry"},
     *      description="Store CalendarEntry",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CalendarEntry that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CalendarEntry")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/CalendarEntry"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCalendarEntryAPIRequest $request)
    {
        $input = $request->all();

        $calendarEntry = $this->calendarEntryRepository->create($input);
        
        CalendarEntryCreated::dispatch($calendarEntry);
        return $this->sendResponse(new CalendarEntryResource($calendarEntry), 'Calendar Entry saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/calendarEntries/{id}",
     *      summary="Display the specified CalendarEntry",
     *      tags={"CalendarEntry"},
     *      description="Get CalendarEntry",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CalendarEntry",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/CalendarEntry"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var CalendarEntry $calendarEntry */
        $calendarEntry = $this->calendarEntryRepository->find($id);

        if (empty($calendarEntry)) {
            return $this->sendError('Calendar Entry not found');
        }

        return $this->sendResponse(new CalendarEntryResource($calendarEntry), 'Calendar Entry retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCalendarEntryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/calendarEntries/{id}",
     *      summary="Update the specified CalendarEntry in storage",
     *      tags={"CalendarEntry"},
     *      description="Update CalendarEntry",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CalendarEntry",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CalendarEntry that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CalendarEntry")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/CalendarEntry"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCalendarEntryAPIRequest $request)
    {
        $input = $request->all();

        /** @var CalendarEntry $calendarEntry */
        $calendarEntry = $this->calendarEntryRepository->find($id);

        if (empty($calendarEntry)) {
            return $this->sendError('Calendar Entry not found');
        }

        $calendarEntry = $this->calendarEntryRepository->update($input, $id);
        
        CalendarEntryUpdated::dispatch($calendarEntry);
        return $this->sendResponse(new CalendarEntryResource($calendarEntry), 'CalendarEntry updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/calendarEntries/{id}",
     *      summary="Remove the specified CalendarEntry from storage",
     *      tags={"CalendarEntry"},
     *      description="Delete CalendarEntry",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CalendarEntry",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var CalendarEntry $calendarEntry */
        $calendarEntry = $this->calendarEntryRepository->find($id);

        if (empty($calendarEntry)) {
            return $this->sendError('Calendar Entry not found');
        }

        $calendarEntry->delete();
        CalendarEntryDeleted::dispatch($calendarEntry);
        return $this->sendSuccess('Calendar Entry deleted successfully');
    }
}
