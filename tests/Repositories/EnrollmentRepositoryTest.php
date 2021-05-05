<?php namespace Tests\Repositories;

use App\Models\Enrollment;
use App\Repositories\EnrollmentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EnrollmentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var EnrollmentRepository
     */
    protected $enrollmentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->enrollmentRepo = \App::make(EnrollmentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_enrollment()
    {
        $enrollment = Enrollment::factory()->make()->toArray();

        $createdEnrollment = $this->enrollmentRepo->create($enrollment);

        $createdEnrollment = $createdEnrollment->toArray();
        $this->assertArrayHasKey('id', $createdEnrollment);
        $this->assertNotNull($createdEnrollment['id'], 'Created Enrollment must have id specified');
        $this->assertNotNull(Enrollment::find($createdEnrollment['id']), 'Enrollment with given id must be in DB');
        $this->assertModelData($enrollment, $createdEnrollment);
    }

    /**
     * @test read
     */
    public function test_read_enrollment()
    {
        $enrollment = Enrollment::factory()->create();

        $dbEnrollment = $this->enrollmentRepo->find($enrollment->id);

        $dbEnrollment = $dbEnrollment->toArray();
        $this->assertModelData($enrollment->toArray(), $dbEnrollment);
    }

    /**
     * @test update
     */
    public function test_update_enrollment()
    {
        $enrollment = Enrollment::factory()->create();
        $fakeEnrollment = Enrollment::factory()->make()->toArray();

        $updatedEnrollment = $this->enrollmentRepo->update($fakeEnrollment, $enrollment->id);

        $this->assertModelData($fakeEnrollment, $updatedEnrollment->toArray());
        $dbEnrollment = $this->enrollmentRepo->find($enrollment->id);
        $this->assertModelData($fakeEnrollment, $dbEnrollment->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_enrollment()
    {
        $enrollment = Enrollment::factory()->create();

        $resp = $this->enrollmentRepo->delete($enrollment->id);

        $this->assertTrue($resp);
        $this->assertNull(Enrollment::find($enrollment->id), 'Enrollment should not exist in DB');
    }
}
