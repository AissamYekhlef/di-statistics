<?php

namespace Database\Factories;

use App\Models\Entity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'entitytype_id' => rand(1,9),
            'created_at' => Carbon::now()->subMinutes(rand(1,20000))
        ];
    }
}
