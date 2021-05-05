<?php namespace Tests\Repositories;

use App\Models\Manager;
use App\Repositories\ManagerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ManagerRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ManagerRepository
     */
    protected $managerRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->managerRepo = \App::make(ManagerRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_manager()
    {
        $manager = Manager::factory()->make()->toArray();

        $createdManager = $this->managerRepo->create($manager);

        $createdManager = $createdManager->toArray();
        $this->assertArrayHasKey('id', $createdManager);
        $this->assertNotNull($createdManager['id'], 'Created Manager must have id specified');
        $this->assertNotNull(Manager::find($createdManager['id']), 'Manager with given id must be in DB');
        $this->assertModelData($manager, $createdManager);
    }

    /**
     * @test read
     */
    public function test_read_manager()
    {
        $manager = Manager::factory()->create();

        $dbManager = $this->managerRepo->find($manager->id);

        $dbManager = $dbManager->toArray();
        $this->assertModelData($manager->toArray(), $dbManager);
    }

    /**
     * @test update
     */
    public function test_update_manager()
    {
        $manager = Manager::factory()->create();
        $fakeManager = Manager::factory()->make()->toArray();

        $updatedManager = $this->managerRepo->update($fakeManager, $manager->id);

        $this->assertModelData($fakeManager, $updatedManager->toArray());
        $dbManager = $this->managerRepo->find($manager->id);
        $this->assertModelData($fakeManager, $dbManager->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_manager()
    {
        $manager = Manager::factory()->create();

        $resp = $this->managerRepo->delete($manager->id);

        $this->assertTrue($resp);
        $this->assertNull(Manager::find($manager->id), 'Manager should not exist in DB');
    }
}
