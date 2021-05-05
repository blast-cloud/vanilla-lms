<?php namespace Tests\Repositories;

use App\Models\Submission;
use App\Repositories\SubmissionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SubmissionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SubmissionRepository
     */
    protected $submissionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->submissionRepo = \App::make(SubmissionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_submission()
    {
        $submission = Submission::factory()->make()->toArray();

        $createdSubmission = $this->submissionRepo->create($submission);

        $createdSubmission = $createdSubmission->toArray();
        $this->assertArrayHasKey('id', $createdSubmission);
        $this->assertNotNull($createdSubmission['id'], 'Created Submission must have id specified');
        $this->assertNotNull(Submission::find($createdSubmission['id']), 'Submission with given id must be in DB');
        $this->assertModelData($submission, $createdSubmission);
    }

    /**
     * @test read
     */
    public function test_read_submission()
    {
        $submission = Submission::factory()->create();

        $dbSubmission = $this->submissionRepo->find($submission->id);

        $dbSubmission = $dbSubmission->toArray();
        $this->assertModelData($submission->toArray(), $dbSubmission);
    }

    /**
     * @test update
     */
    public function test_update_submission()
    {
        $submission = Submission::factory()->create();
        $fakeSubmission = Submission::factory()->make()->toArray();

        $updatedSubmission = $this->submissionRepo->update($fakeSubmission, $submission->id);

        $this->assertModelData($fakeSubmission, $updatedSubmission->toArray());
        $dbSubmission = $this->submissionRepo->find($submission->id);
        $this->assertModelData($fakeSubmission, $dbSubmission->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_submission()
    {
        $submission = Submission::factory()->create();

        $resp = $this->submissionRepo->delete($submission->id);

        $this->assertTrue($resp);
        $this->assertNull(Submission::find($submission->id), 'Submission should not exist in DB');
    }
}
