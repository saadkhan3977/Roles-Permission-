<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $table ='categories';
    protected $guarded=[];
    use HasFactory;
    
    
    // public function subcategory() 
    // {
    //     return $this->belongsTo('App\Models\SubCategory','id','category_ids');
    // }


}
