<?php

namespace Database\Factories;

use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

class LecturerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lecturer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->word,
        'telephone' => $this->faker->word,
        'job_title' => $this->faker->word,
        'first_name' => $this->faker->word,
        'last_name' => $this->faker->word,
        'picture_file_path' => $this->faker->word,
        'profile_external_url' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'department_id' => $this->faker->randomDigitNotNull
        ];
    }
}
