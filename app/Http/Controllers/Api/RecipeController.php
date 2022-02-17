<?php

namespace App\Http\Controllers\Api;

   use App\Models\Recipe;
   use App\Models\Category;
   use Illuminate\Support\Facades\Validator;
   use App\Http\Requests\Api\RecipesRequest;
   use App\Http\Controllers\API\BaseController as BaseController;
   use App\Http\Resources\Api\RecipeResource as RecipeResource;

class RecipeController extends BaseController
{
        /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
        public function index()
        {
            $recipes = Recipe::all();
        
            return  new RecipeResource($recipes);
        }
        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(RecipesRequest $request)
        {
            $input = $request->all();
       
            $validator = Validator::make($input, [
                'name' => 'required',
                'imgUrl' => 'required', 
                'ingredients' => 'required',
                'steps'  => 'required',
                'category_id' => 'required',
                ]);
       
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            $recipe = new Recipe();
            $recipe->name = $request->name;
            $recipe->imgUrl = $request->imgUrl;
            $recipe->ingredients = $request->ingredients;
            $recipe->steps = $request->steps;
            $recipe->category_id = $request->category_id;
            $recipe->save();
 
            $category =Category::find($request->category_id);
            $category->recipes()->attach($recipe->id);
 
         //    $recipe = Recipe::create($input);
       
            return $this->sendResponse(new RecipeResource($recipe), 'Recipe created successfully.');
        } 
       
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $recipe = Recipe::find($id);
      
            if (is_null($recipe)) {
                return $this->sendError('Recipe not found.');
            }
       
            return $this->sendResponse(new RecipeResource($recipe), 'Recipe retrieved successfully.');
        }
        
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(RecipesRequest $request, Recipe $recipe)
        {
            $input = $request->all();
       
            $validator = Validator::make($input, [
                'name' => 'required',
                'imgUrl' => 'required', 
                'ingredients' => 'required',
                'steps'  => 'required',
                'category_id' => 'required',
                ]);
       
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            $recipe = new Recipe();
            $recipe->name = $request->name;
            $recipe->imgUrl = $request->imgUrl;
            $recipe->ingredients = $request->ingredients;
            $recipe->steps = $request->steps;
            $recipe->category_id = $request->category_id;
            $recipe->save();
 
            $category =Category::find($request->category_id);
            $category->recipes()->attach($recipe->id);
 
         //    $recipe = Recipe::create($input);
       
            return $this->sendResponse(new RecipeResource($recipe), 'Recipe updated successfully.');
        }
       
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Recipe $recipe)
        {
            $recipe->delete();
       
            return $this->sendResponse([], 'Recipe deleted successfully.');
        }
    }
 