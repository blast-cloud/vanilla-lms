<?php namespace Tests\Repositories;

use App\Models\Grade;
use App\Repositories\GradeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class GradeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var GradeRepository
     */
    protected $gradeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->gradeRepo = \App::make(GradeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_grade()
    {
        $grade = Grade::factory()->make()->toArray();

        $createdGrade = $this->gradeRepo->create($grade);

        $createdGrade = $createdGrade->toArray();
        $this->assertArrayHasKey('id', $createdGrade);
        $this->assertNotNull($createdGrade['id'], 'Created Grade must have id specified');
        $this->assertNotNull(Grade::find($createdGrade['id']), 'Grade with given id must be in DB');
        $this->assertModelData($grade, $createdGrade);
    }

    /**
     * @test read
     */
    public function test_read_grade()
    {
        $grade = Grade::factory()->create();

        $dbGrade = $this->gradeRepo->find($grade->id);

        $dbGrade = $dbGrade->toArray();
        $this->assertModelData($grade->toArray(), $dbGrade);
    }

    /**
     * @test update
     */
    public function test_update_grade()
    {
        $grade = Grade::factory()->create();
        $fakeGrade = Grade::factory()->make()->toArray();

        $updatedGrade = $this->gradeRepo->update($fakeGrade, $grade->id);

        $this->assertModelData($fakeGrade, $updatedGrade->toArray());
        $dbGrade = $this->gradeRepo->find($grade->id);
        $this->assertModelData($fakeGrade, $dbGrade->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_grade()
    {
        $grade = Grade::factory()->create();

        $resp = $this->gradeRepo->delete($grade->id);

        $this->assertTrue($resp);
        $this->assertNull(Grade::find($grade->id), 'Grade should not exist in DB');
    }
}
