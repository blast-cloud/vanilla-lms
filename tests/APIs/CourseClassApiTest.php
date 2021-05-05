<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CourseClass;

class CourseClassApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_course_class()
    {
        $courseClass = CourseClass::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/course_classes', $courseClass
        );

        $this->assertApiResponse($courseClass);
    }

    /**
     * @test
     */
    public function test_read_course_class()
    {
        $courseClass = CourseClass::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/course_classes/'.$courseClass->id
        );

        $this->assertApiResponse($courseClass->toArray());
    }

    /**
     * @test
     */
    public function test_update_course_class()
    {
        $courseClass = CourseClass::factory()->create();
        $editedCourseClass = CourseClass::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/course_classes/'.$courseClass->id,
            $editedCourseClass
        );

        $this->assertApiResponse($editedCourseClass);
    }

    /**
     * @test
     */
    public function test_delete_course_class()
    {
        $courseClass = CourseClass::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/course_classes/'.$courseClass->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/course_classes/'.$courseClass->id
        );

        $this->response->assertStatus(404);
    }
}
