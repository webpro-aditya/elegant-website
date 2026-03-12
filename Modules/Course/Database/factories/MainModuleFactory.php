<?php

namespace Modules\Course\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MainModuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Course\Entities\MainModule::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'heading' => fake()->name(),
            'title' => fake()->name(),
            'course_id' => fake()->numberBetween(1, 10),
            'batch_id' => fake()->numberBetween(1, 10),
        ];
    }
}
