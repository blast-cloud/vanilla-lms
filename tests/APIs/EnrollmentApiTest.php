<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Enrollment;

class EnrollmentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_enrollment()
    {
        $enrollment = Enrollment::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/enrollments', $enrollment
        );

        $this->assertApiResponse($enrollment);
    }

    /**
     * @test
     */
    public function test_read_enrollment()
    {
        $enrollment = Enrollment::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/enrollments/'.$enrollment->id
        );

        $this->assertApiResponse($enrollment->toArray());
    }

    /**
     * @test
     */
    public function test_update_enrollment()
    {
        $enrollment = Enrollment::factory()->create();
        $editedEnrollment = Enrollment::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/enrollments/'.$enrollment->id,
            $editedEnrollment
        );

        $this->assertApiResponse($editedEnrollment);
    }

    /**
     * @test
     */
    public function test_delete_enrollment()
    {
        $enrollment = Enrollment::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/enrollments/'.$enrollment->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/enrollments/'.$enrollment->id
        );

        $this->response->assertStatus(404);
    }
}
