<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    public static $wrap = 'recipe';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'imgUrl' => $this->imgUrl,
           
        //     'description' =>[
        //         'ingredients' => $this->ingredients,
        //         'steps' => $this->steps,
        //         'category_id' => $this->category_id,
        //     ]
           
        // ];
    }
    public function with($request){
        return [
            'status'=>'success'
        ];
    }
}
