<?php

namespace Database\Factories;

use App\Models\CourseClassFeedbackResponse;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseClassFeedbackResponseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseClassFeedbackResponse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'note' => $this->faker->word,
            'assignments_rating_point' => $this->faker->numberBetween(0,5),
            'clarification_rating_point' => $this->faker->numberBetween(0,5),
            'examination_rating_point' => $this->faker->numberBetween(0,5),
            'leading_rating_point' => $this->faker->numberBetween(0,5),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'course_class_feedback_id' => $this->faker->randomDigitNotNull,
            'course_class_id' => $this->faker->randomDigitNotNull,
            'student_id' => $this->faker->randomDigitNotNull,
            'lecturer_id' => $this->faker->randomDigitNotNull,
            'department_id' => $this->faker->randomDigitNotNull,
            'semester_id' => $this->faker->randomDigitNotNull
        
        ];
    }
}
