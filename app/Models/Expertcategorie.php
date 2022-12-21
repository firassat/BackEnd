<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expertcategorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'categories_id',
        'experts_id',
        'experiance',
        'experiance_details'
    ];
   /* public function categorie()
    {
        return $this->hasMany(Categorie::class,'categories_id');
    }*/
    public function expert()
    {
        return  $this->belongsTo(Expert::class,'experts_id');
    }


}
