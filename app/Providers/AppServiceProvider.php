<?php

namespace App\Providers;

use App\Http\Resources\Api\RecipeResource;
use App\Models\Recipe;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    //    RecipeResource::withoutWrapping();
    }
}
