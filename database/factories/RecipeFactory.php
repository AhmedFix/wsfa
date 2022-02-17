<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name(),
            'imgUrl'=> $this->faker->imageUrl(),
            'ingredients' => $this->faker->sentence(),
            'steps' => $this->faker->sentence(),
            'category_id'=> function(){
                return Category::all()->random();
            }
        ];
    }
}