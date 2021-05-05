<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CalendarEntry;

class CalendarEntryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_calendar_entry()
    {
        $calendarEntry = CalendarEntry::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/calendar_entries', $calendarEntry
        );

        $this->assertApiResponse($calendarEntry);
    }

    /**
     * @test
     */
    public function test_read_calendar_entry()
    {
        $calendarEntry = CalendarEntry::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/calendar_entries/'.$calendarEntry->id
        );

        $this->assertApiResponse($calendarEntry->toArray());
    }

    /**
     * @test
     */
    public function test_update_calendar_entry()
    {
        $calendarEntry = CalendarEntry::factory()->create();
        $editedCalendarEntry = CalendarEntry::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/calendar_entries/'.$calendarEntry->id,
            $editedCalendarEntry
        );

        $this->assertApiResponse($editedCalendarEntry);
    }

    /**
     * @test
     */
    public function test_delete_calendar_entry()
    {
        $calendarEntry = CalendarEntry::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/calendar_entries/'.$calendarEntry->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/calendar_entries/'.$calendarEntry->id
        );

        $this->response->assertStatus(404);
    }
}
