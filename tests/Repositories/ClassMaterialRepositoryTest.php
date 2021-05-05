<?php namespace Tests\Repositories;

use App\Models\ClassMaterial;
use App\Repositories\ClassMaterialRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ClassMaterialRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ClassMaterialRepository
     */
    protected $classMaterialRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->classMaterialRepo = \App::make(ClassMaterialRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_class_material()
    {
        $classMaterial = ClassMaterial::factory()->make()->toArray();

        $createdClassMaterial = $this->classMaterialRepo->create($classMaterial);

        $createdClassMaterial = $createdClassMaterial->toArray();
        $this->assertArrayHasKey('id', $createdClassMaterial);
        $this->assertNotNull($createdClassMaterial['id'], 'Created ClassMaterial must have id specified');
        $this->assertNotNull(ClassMaterial::find($createdClassMaterial['id']), 'ClassMaterial with given id must be in DB');
        $this->assertModelData($classMaterial, $createdClassMaterial);
    }

    /**
     * @test read
     */
    public function test_read_class_material()
    {
        $classMaterial = ClassMaterial::factory()->create();

        $dbClassMaterial = $this->classMaterialRepo->find($classMaterial->id);

        $dbClassMaterial = $dbClassMaterial->toArray();
        $this->assertModelData($classMaterial->toArray(), $dbClassMaterial);
    }

    /**
     * @test update
     */
    public function test_update_class_material()
    {
        $classMaterial = ClassMaterial::factory()->create();
        $fakeClassMaterial = ClassMaterial::factory()->make()->toArray();

        $updatedClassMaterial = $this->classMaterialRepo->update($fakeClassMaterial, $classMaterial->id);

        $this->assertModelData($fakeClassMaterial, $updatedClassMaterial->toArray());
        $dbClassMaterial = $this->classMaterialRepo->find($classMaterial->id);
        $this->assertModelData($fakeClassMaterial, $dbClassMaterial->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_class_material()
    {
        $classMaterial = ClassMaterial::factory()->create();

        $resp = $this->classMaterialRepo->delete($classMaterial->id);

        $this->assertTrue($resp);
        $this->assertNull(ClassMaterial::find($classMaterial->id), 'ClassMaterial should not exist in DB');
    }
}
