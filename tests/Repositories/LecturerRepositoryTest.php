<?php namespace Tests\Repositories;

use App\Models\Lecturer;
use App\Repositories\LecturerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LecturerRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LecturerRepository
     */
    protected $lecturerRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->lecturerRepo = \App::make(LecturerRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_lecturer()
    {
        $lecturer = Lecturer::factory()->make()->toArray();

        $createdLecturer = $this->lecturerRepo->create($lecturer);

        $createdLecturer = $createdLecturer->toArray();
        $this->assertArrayHasKey('id', $createdLecturer);
        $this->assertNotNull($createdLecturer['id'], 'Created Lecturer must have id specified');
        $this->assertNotNull(Lecturer::find($createdLecturer['id']), 'Lecturer with given id must be in DB');
        $this->assertModelData($lecturer, $createdLecturer);
    }

    /**
     * @test read
     */
    public function test_read_lecturer()
    {
        $lecturer = Lecturer::factory()->create();

        $dbLecturer = $this->lecturerRepo->find($lecturer->id);

        $dbLecturer = $dbLecturer->toArray();
        $this->assertModelData($lecturer->toArray(), $dbLecturer);
    }

    /**
     * @test update
     */
    public function test_update_lecturer()
    {
        $lecturer = Lecturer::factory()->create();
        $fakeLecturer = Lecturer::factory()->make()->toArray();

        $updatedLecturer = $this->lecturerRepo->update($fakeLecturer, $lecturer->id);

        $this->assertModelData($fakeLecturer, $updatedLecturer->toArray());
        $dbLecturer = $this->lecturerRepo->find($lecturer->id);
        $this->assertModelData($fakeLecturer, $dbLecturer->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_lecturer()
    {
        $lecturer = Lecturer::factory()->create();

        $resp = $this->lecturerRepo->delete($lecturer->id);

        $this->assertTrue($resp);
        $this->assertNull(Lecturer::find($lecturer->id), 'Lecturer should not exist in DB');
    }
}
