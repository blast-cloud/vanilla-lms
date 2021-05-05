<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Lecturer;

class LecturerApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_lecturer()
    {
        $lecturer = Lecturer::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/lecturers', $lecturer
        );

        $this->assertApiResponse($lecturer);
    }

    /**
     * @test
     */
    public function test_read_lecturer()
    {
        $lecturer = Lecturer::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/lecturers/'.$lecturer->id
        );

        $this->assertApiResponse($lecturer->toArray());
    }

    /**
     * @test
     */
    public function test_update_lecturer()
    {
        $lecturer = Lecturer::factory()->create();
        $editedLecturer = Lecturer::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/lecturers/'.$lecturer->id,
            $editedLecturer
        );

        $this->assertApiResponse($editedLecturer);
    }

    /**
     * @test
     */
    public function test_delete_lecturer()
    {
        $lecturer = Lecturer::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/lecturers/'.$lecturer->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/lecturers/'.$lecturer->id
        );

        $this->response->assertStatus(404);
    }
}
