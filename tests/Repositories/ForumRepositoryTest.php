<?php namespace Tests\Repositories;

use App\Models\Forum;
use App\Repositories\ForumRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ForumRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ForumRepository
     */
    protected $forumRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->forumRepo = \App::make(ForumRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_forum()
    {
        $forum = Forum::factory()->make()->toArray();

        $createdForum = $this->forumRepo->create($forum);

        $createdForum = $createdForum->toArray();
        $this->assertArrayHasKey('id', $createdForum);
        $this->assertNotNull($createdForum['id'], 'Created Forum must have id specified');
        $this->assertNotNull(Forum::find($createdForum['id']), 'Forum with given id must be in DB');
        $this->assertModelData($forum, $createdForum);
    }

    /**
     * @test read
     */
    public function test_read_forum()
    {
        $forum = Forum::factory()->create();

        $dbForum = $this->forumRepo->find($forum->id);

        $dbForum = $dbForum->toArray();
        $this->assertModelData($forum->toArray(), $dbForum);
    }

    /**
     * @test update
     */
    public function test_update_forum()
    {
        $forum = Forum::factory()->create();
        $fakeForum = Forum::factory()->make()->toArray();

        $updatedForum = $this->forumRepo->update($fakeForum, $forum->id);

        $this->assertModelData($fakeForum, $updatedForum->toArray());
        $dbForum = $this->forumRepo->find($forum->id);
        $this->assertModelData($fakeForum, $dbForum->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_forum()
    {
        $forum = Forum::factory()->create();

        $resp = $this->forumRepo->delete($forum->id);

        $this->assertTrue($resp);
        $this->assertNull(Forum::find($forum->id), 'Forum should not exist in DB');
    }
}
