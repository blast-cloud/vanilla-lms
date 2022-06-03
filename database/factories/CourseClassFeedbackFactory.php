<?php

namespace Database\Factories;

use App\Models\CourseClassFeedback;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseClassFeedbackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseClassFeedback::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'note' => $this->faker->word,
            'start_date' => $this->faker->date('Y-m-d H:i:s'),
            'end_date' => $this->faker->date('Y-m-d H:i:s'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'department_id' => $this->faker->randomDigitNotNull,
            'course_class_id' => $this->faker->randomDigitNotNull,
            'creator_user_id' => $this->faker->randomDigitNotNull
        ];
    }
}
