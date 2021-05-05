<?php

namespace App\Http\Controllers;

use App\Events\CalendarEntryCreated;
use App\Events\CalendarEntryUpdated;
use App\Events\CalendarEntryDeleted;

use App\DataTables\CalendarEntryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCalendarEntryRequest;
use App\Http\Requests\UpdateCalendarEntryRequest;
use App\Repositories\CalendarEntryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CalendarEntryController extends AppBaseController
{
    /** @var  CalendarEntryRepository */
    private $calendarEntryRepository;

    public function __construct(CalendarEntryRepository $calendarEntryRepo)
    {
        $this->calendarEntryRepository = $calendarEntryRepo;
    }

    /**
     * Display a listing of the CalendarEntry.
     *
     * @param CalendarEntryDataTable $calendarEntryDataTable
     * @return Response
     */
    public function index(CalendarEntryDataTable $calendarEntryDataTable)
    {
        return $calendarEntryDataTable->render('calendar_entries.index');
    }

    /**
     * Show the form for creating a new CalendarEntry.
     *
     * @return Response
     */
    public function create()
    {
        return view('calendar_entries.create');
    }

    /**
     * Store a newly created CalendarEntry in storage.
     *
     * @param CreateCalendarEntryRequest $request
     *
     * @return Response
     */
    public function store(CreateCalendarEntryRequest $request)
    {
        $input = $request->all();

        $calendarEntry = $this->calendarEntryRepository->create($input);

        Flash::success('Calendar Entry saved successfully.');
        
        CalendarEntryCreated::dispatch($calendarEntry);
        return redirect(route('calendarEntries.index'));
    }

    /**
     * Display the specified CalendarEntry.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $calendarEntry = $this->calendarEntryRepository->find($id);

        if (empty($calendarEntry)) {
            Flash::error('Calendar Entry not found');

            return redirect(route('calendarEntries.index'));
        }

        return view('calendar_entries.show')->with('calendarEntry', $calendarEntry);
    }

    /**
     * Show the form for editing the specified CalendarEntry.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $calendarEntry = $this->calendarEntryRepository->find($id);

        if (empty($calendarEntry)) {
            Flash::error('Calendar Entry not found');

            return redirect(route('calendarEntries.index'));
        }

        return view('calendar_entries.edit')->with('calendarEntry', $calendarEntry);
    }

    /**
     * Update the specified CalendarEntry in storage.
     *
     * @param  int              $id
     * @param UpdateCalendarEntryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCalendarEntryRequest $request)
    {
        $calendarEntry = $this->calendarEntryRepository->find($id);

        if (empty($calendarEntry)) {
            Flash::error('Calendar Entry not found');

            return redirect(route('calendarEntries.index'));
        }

        $calendarEntry = $this->calendarEntryRepository->update($request->all(), $id);

        Flash::success('Calendar Entry updated successfully.');
        
        CalendarEntryUpdated::dispatch($calendarEntry);
        return redirect(route('calendarEntries.index'));
    }

    /**
     * Remove the specified CalendarEntry from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $calendarEntry = $this->calendarEntryRepository->find($id);

        if (empty($calendarEntry)) {
            Flash::error('Calendar Entry not found');

            return redirect(route('calendarEntries.index'));
        }

        $this->calendarEntryRepository->delete($id);

        Flash::success('Calendar Entry deleted successfully.');

        CalendarEntryDeleted::dispatch($calendarEntry);
        return redirect(route('calendarEntries.index'));
    }
}
