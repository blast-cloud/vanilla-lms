<?php

namespace Database\Factories;

use App\Models\ClassMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassMaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassMaterial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->word,
        'title' => $this->faker->word,
        'description' => $this->faker->text,
        'lecture_number' => $this->faker->randomDigitNotNull,
        'assignment_number' => $this->faker->randomDigitNotNull,
        'due_date' => $this->faker->date('Y-m-d H:i:s'),
        'blackboard_meeting_id' => $this->faker->word,
        'blackboard_meeting_status' => $this->faker->word,
        'upload_file_path' => $this->faker->word,
        'upload_file_type' => $this->faker->word,
        'reference_material_url' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'course_class_id' => $this->faker->randomDigitNotNull
        ];
    }
}
