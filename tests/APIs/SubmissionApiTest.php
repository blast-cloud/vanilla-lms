<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Submission;

class SubmissionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_submission()
    {
        $submission = Submission::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/submissions', $submission
        );

        $this->assertApiResponse($submission);
    }

    /**
     * @test
     */
    public function test_read_submission()
    {
        $submission = Submission::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/submissions/'.$submission->id
        );

        $this->assertApiResponse($submission->toArray());
    }

    /**
     * @test
     */
    public function test_update_submission()
    {
        $submission = Submission::factory()->create();
        $editedSubmission = Submission::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/submissions/'.$submission->id,
            $editedSubmission
        );

        $this->assertApiResponse($editedSubmission);
    }

    /**
     * @test
     */
    public function test_delete_submission()
    {
        $submission = Submission::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/submissions/'.$submission->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/submissions/'.$submission->id
        );

        $this->response->assertStatus(404);
    }
}
