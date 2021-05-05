<?php namespace Tests\Repositories;

use App\Models\CourseClass;
use App\Repositories\CourseClassRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CourseClassRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CourseClassRepository
     */
    protected $courseClassRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->courseClassRepo = \App::make(CourseClassRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_course_class()
    {
        $courseClass = CourseClass::factory()->make()->toArray();

        $createdCourseClass = $this->courseClassRepo->create($courseClass);

        $createdCourseClass = $createdCourseClass->toArray();
        $this->assertArrayHasKey('id', $createdCourseClass);
        $this->assertNotNull($createdCourseClass['id'], 'Created CourseClass must have id specified');
        $this->assertNotNull(CourseClass::find($createdCourseClass['id']), 'CourseClass with given id must be in DB');
        $this->assertModelData($courseClass, $createdCourseClass);
    }

    /**
     * @test read
     */
    public function test_read_course_class()
    {
        $courseClass = CourseClass::factory()->create();

        $dbCourseClass = $this->courseClassRepo->find($courseClass->id);

        $dbCourseClass = $dbCourseClass->toArray();
        $this->assertModelData($courseClass->toArray(), $dbCourseClass);
    }

    /**
     * @test update
     */
    public function test_update_course_class()
    {
        $courseClass = CourseClass::factory()->create();
        $fakeCourseClass = CourseClass::factory()->make()->toArray();

        $updatedCourseClass = $this->courseClassRepo->update($fakeCourseClass, $courseClass->id);

        $this->assertModelData($fakeCourseClass, $updatedCourseClass->toArray());
        $dbCourseClass = $this->courseClassRepo->find($courseClass->id);
        $this->assertModelData($fakeCourseClass, $dbCourseClass->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_course_class()
    {
        $courseClass = CourseClass::factory()->create();

        $resp = $this->courseClassRepo->delete($courseClass->id);

        $this->assertTrue($resp);
        $this->assertNull(CourseClass::find($courseClass->id), 'CourseClass should not exist in DB');
    }
}
