<?php

namespace Database\Factories;

use App\Models\CalendarEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

class CalendarEntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CalendarEntry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
        'due_date' => $this->faker->word,
        'description' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'course_class_id' => $this->faker->randomDigitNotNull,
        'department_id' => $this->faker->randomDigitNotNull
        ];
    }
}
