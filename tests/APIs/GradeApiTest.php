<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Grade;

class GradeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_grade()
    {
        $grade = Grade::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/grades', $grade
        );

        $this->assertApiResponse($grade);
    }

    /**
     * @test
     */
    public function test_read_grade()
    {
        $grade = Grade::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/grades/'.$grade->id
        );

        $this->assertApiResponse($grade->toArray());
    }

    /**
     * @test
     */
    public function test_update_grade()
    {
        $grade = Grade::factory()->create();
        $editedGrade = Grade::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/grades/'.$grade->id,
            $editedGrade
        );

        $this->assertApiResponse($editedGrade);
    }

    /**
     * @test
     */
    public function test_delete_grade()
    {
        $grade = Grade::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/grades/'.$grade->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/grades/'.$grade->id
        );

        $this->response->assertStatus(404);
    }
}
