<?php

namespace Modules\Cms\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContentItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Cms\Entities\ContentItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
