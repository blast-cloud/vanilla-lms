<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ClassMaterial;

class ClassMaterialApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_class_material()
    {
        $classMaterial = ClassMaterial::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/class_materials', $classMaterial
        );

        $this->assertApiResponse($classMaterial);
    }

    /**
     * @test
     */
    public function test_read_class_material()
    {
        $classMaterial = ClassMaterial::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/class_materials/'.$classMaterial->id
        );

        $this->assertApiResponse($classMaterial->toArray());
    }

    /**
     * @test
     */
    public function test_update_class_material()
    {
        $classMaterial = ClassMaterial::factory()->create();
        $editedClassMaterial = ClassMaterial::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/class_materials/'.$classMaterial->id,
            $editedClassMaterial
        );

        $this->assertApiResponse($editedClassMaterial);
    }

    /**
     * @test
     */
    public function test_delete_class_material()
    {
        $classMaterial = ClassMaterial::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/class_materials/'.$classMaterial->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/class_materials/'.$classMaterial->id
        );

        $this->response->assertStatus(404);
    }
}
