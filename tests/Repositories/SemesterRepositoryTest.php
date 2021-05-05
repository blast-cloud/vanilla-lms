<?php namespace Tests\Repositories;

use App\Models\Semester;
use App\Repositories\SemesterRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SemesterRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SemesterRepository
     */
    protected $semesterRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->semesterRepo = \App::make(SemesterRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_semester()
    {
        $semester = Semester::factory()->make()->toArray();

        $createdSemester = $this->semesterRepo->create($semester);

        $createdSemester = $createdSemester->toArray();
        $this->assertArrayHasKey('id', $createdSemester);
        $this->assertNotNull($createdSemester['id'], 'Created Semester must have id specified');
        $this->assertNotNull(Semester::find($createdSemester['id']), 'Semester with given id must be in DB');
        $this->assertModelData($semester, $createdSemester);
    }

    /**
     * @test read
     */
    public function test_read_semester()
    {
        $semester = Semester::factory()->create();

        $dbSemester = $this->semesterRepo->find($semester->id);

        $dbSemester = $dbSemester->toArray();
        $this->assertModelData($semester->toArray(), $dbSemester);
    }

    /**
     * @test update
     */
    public function test_update_semester()
    {
        $semester = Semester::factory()->create();
        $fakeSemester = Semester::factory()->make()->toArray();

        $updatedSemester = $this->semesterRepo->update($fakeSemester, $semester->id);

        $this->assertModelData($fakeSemester, $updatedSemester->toArray());
        $dbSemester = $this->semesterRepo->find($semester->id);
        $this->assertModelData($fakeSemester, $dbSemester->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_semester()
    {
        $semester = Semester::factory()->create();

        $resp = $this->semesterRepo->delete($semester->id);

        $this->assertTrue($resp);
        $this->assertNull(Semester::find($semester->id), 'Semester should not exist in DB');
    }
}
