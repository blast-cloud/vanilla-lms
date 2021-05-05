<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Semester;

class SemesterApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_semester()
    {
        $semester = Semester::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/semesters', $semester
        );

        $this->assertApiResponse($semester);
    }

    /**
     * @test
     */
    public function test_read_semester()
    {
        $semester = Semester::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/semesters/'.$semester->id
        );

        $this->assertApiResponse($semester->toArray());
    }

    /**
     * @test
     */
    public function test_update_semester()
    {
        $semester = Semester::factory()->create();
        $editedSemester = Semester::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/semesters/'.$semester->id,
            $editedSemester
        );

        $this->assertApiResponse($editedSemester);
    }

    /**
     * @test
     */
    public function test_delete_semester()
    {
        $semester = Semester::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/semesters/'.$semester->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/semesters/'.$semester->id
        );

        $this->response->assertStatus(404);
    }
}
