<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Recipe;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(mt_rand(3, 6)),
        ];
    }

    // public function configure()
    // {
        
    //     return $this->afterCreating(function($category){
    //         $recipe = Recipe::create([
    //             'name'=>$this->faker->name(),
    //             'imgUrl'=> $this->faker->imageUrl(),
    //             'ingredients' => $this->faker->sentence(),
    //             'steps' => $this->faker->sentence(),
    //             'category_id'=> function(){
    //                 return Category::all()->random();
    //             }
    //         ]);
    //         $category->recipes()->attach($recipe->id);
    //     });

    // }
}
