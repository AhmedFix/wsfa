<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'imgUrl', 
        'ingredients',
        'steps',
        'category_id'
   ];
   
   protected $hidden = [
       'created_at',
       'updated_at',
       'pivot'
   ];
   public function categories(){
       return $this->belongs(category::class);
   }
}
