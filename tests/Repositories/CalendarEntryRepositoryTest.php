<?php namespace Tests\Repositories;

use App\Models\CalendarEntry;
use App\Repositories\CalendarEntryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CalendarEntryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CalendarEntryRepository
     */
    protected $calendarEntryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->calendarEntryRepo = \App::make(CalendarEntryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_calendar_entry()
    {
        $calendarEntry = CalendarEntry::factory()->make()->toArray();

        $createdCalendarEntry = $this->calendarEntryRepo->create($calendarEntry);

        $createdCalendarEntry = $createdCalendarEntry->toArray();
        $this->assertArrayHasKey('id', $createdCalendarEntry);
        $this->assertNotNull($createdCalendarEntry['id'], 'Created CalendarEntry must have id specified');
        $this->assertNotNull(CalendarEntry::find($createdCalendarEntry['id']), 'CalendarEntry with given id must be in DB');
        $this->assertModelData($calendarEntry, $createdCalendarEntry);
    }

    /**
     * @test read
     */
    public function test_read_calendar_entry()
    {
        $calendarEntry = CalendarEntry::factory()->create();

        $dbCalendarEntry = $this->calendarEntryRepo->find($calendarEntry->id);

        $dbCalendarEntry = $dbCalendarEntry->toArray();
        $this->assertModelData($calendarEntry->toArray(), $dbCalendarEntry);
    }

    /**
     * @test update
     */
    public function test_update_calendar_entry()
    {
        $calendarEntry = CalendarEntry::factory()->create();
        $fakeCalendarEntry = CalendarEntry::factory()->make()->toArray();

        $updatedCalendarEntry = $this->calendarEntryRepo->update($fakeCalendarEntry, $calendarEntry->id);

        $this->assertModelData($fakeCalendarEntry, $updatedCalendarEntry->toArray());
        $dbCalendarEntry = $this->calendarEntryRepo->find($calendarEntry->id);
        $this->assertModelData($fakeCalendarEntry, $dbCalendarEntry->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_calendar_entry()
    {
        $calendarEntry = CalendarEntry::factory()->create();

        $resp = $this->calendarEntryRepo->delete($calendarEntry->id);

        $this->assertTrue($resp);
        $this->assertNull(CalendarEntry::find($calendarEntry->id), 'CalendarEntry should not exist in DB');
    }
}
