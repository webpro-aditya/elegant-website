<?php

namespace Modules\Cms\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContentCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Cms\Entities\ContentCategory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
