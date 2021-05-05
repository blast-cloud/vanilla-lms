<?php

namespace Database\Factories;

use App\Models\CourseClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseClassFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseClass::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->word,
        'name' => $this->faker->word,
        'email_address' => $this->faker->word,
        'telephone' => $this->faker->word,
        'location' => $this->faker->word,
        'monday_time' => $this->faker->word,
        'tuesday_time' => $this->faker->word,
        'wednesday_time' => $this->faker->word,
        'thursday_time' => $this->faker->word,
        'friday_time' => $this->faker->word,
        'saturday_time' => $this->faker->word,
        'sunday_time' => $this->faker->word,
        'credit_hours' => $this->faker->randomDigitNotNull,
        'next_lecture_date' => $this->faker->word,
        'next_exam_date' => $this->faker->word,
        'outline' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'course_id' => $this->faker->randomDigitNotNull,
        'semester_id' => $this->faker->randomDigitNotNull,
        'department_id' => $this->faker->randomDigitNotNull,
        'lecturer_id' => $this->faker->randomDigitNotNull
        ];
    }
}
