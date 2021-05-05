<?php

namespace Database\Factories;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Enrollment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'student_id' => $this->faker->randomDigitNotNull,
        'course_class_id' => $this->faker->randomDigitNotNull,
        'semester_id' => $this->faker->randomDigitNotNull,
        'department_id' => $this->faker->randomDigitNotNull
        ];
    }
}
