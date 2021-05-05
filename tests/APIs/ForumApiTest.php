<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Forum;

class ForumApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_forum()
    {
        $forum = Forum::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/forums', $forum
        );

        $this->assertApiResponse($forum);
    }

    /**
     * @test
     */
    public function test_read_forum()
    {
        $forum = Forum::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/forums/'.$forum->id
        );

        $this->assertApiResponse($forum->toArray());
    }

    /**
     * @test
     */
    public function test_update_forum()
    {
        $forum = Forum::factory()->create();
        $editedForum = Forum::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/forums/'.$forum->id,
            $editedForum
        );

        $this->assertApiResponse($editedForum);
    }

    /**
     * @test
     */
    public function test_delete_forum()
    {
        $forum = Forum::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/forums/'.$forum->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/forums/'.$forum->id
        );

        $this->response->assertStatus(404);
    }
}
